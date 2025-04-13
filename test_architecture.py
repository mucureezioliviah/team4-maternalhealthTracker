"""
Integration tests for architectural metrics:
- Component cohesion
- Inter-module coupling
- System morphology
- Cross-component analysis
"""

import pytest
from pathlib import Path
from metrics.architecture import SoftwareSystem
from metrics.control_flow import ControlFlowGraph

@pytest.fixture
def sample_system():
    """Builds a synthetic system for testing"""
    system = SoftwareSystem()
    
    # Create components
    auth = system.add_component("authentication")
    db = system.add_component("database")
    api = system.add_component("api")
    ui = system.add_component("ui")
    
    # Define relationships
    system.add_relation(ui, auth)          # UI calls auth
    system.add_relation(auth, db)          # Auth uses database
    system.add_relation(api, db)           # API uses database
    system.add_relation(auth, api)         # Auth calls API
    system.add_relation(db, db, True)      # Internal DB call
    
    return system

class TestArchitecturalMetrics:
    def test_cohesion_calculation(self, sample_system):
        """Verify cohesion metrics for components"""
        auth = next(c for c in sample_system.components if c['name'] == "authentication")
        db = next(c for c in sample_system.components if c['name'] == "database")
        
        # Database has higher cohesion (internal call)
        assert db['internal_relations'] == 1
        assert auth['internal_relations'] == 0
        
        # System cohesion should be between 0-1
        cohesion = sample_system.calculate_cohesion()
        assert 0 <= cohesion <= 1
        assert pytest.approx(cohesion, 0.25)  # Expected: 0.25 (1 internal / 4 total relations)

    def test_coupling_calculation(self, sample_system):
        """Verify coupling between components"""
        coupling = sample_system.calculate_coupling()
        assert 0 <= coupling <= 1
        assert pytest.approx(coupling, 0.75)  # Expected: 0.75 (3 external / 4 total relations)
        
        # Verify UI->Auth coupling
        ui = next(c for c in sample_system.components if c['name'] == "ui")
        assert ui['internal_relations'] == 0
        assert sum(1 for r in sample_system.relations 
                  if r['source'] == ui and not r['internal']) == 1

    def test_morphology_metrics(self, sample_system):
        """Test system shape characteristics"""
        # Edge-to-node ratio
        assert len(sample_system.relations) == 5
        assert len(sample_system.components) == 4
        assert sample_system.e_to_n_ratio() == 5/4  # 1.25

        # Depth calculation (longest path)
        assert sample_system.calculate_depth() == 3  # UI -> Auth -> API -> DB

    def test_real_project_analysis(self):
        """Integration test with actual project structure"""
        system = SoftwareSystem()
        
        # Mock analysis of a real project
        components = {
            "main": system.add_component("main"),
            "utils": system.add_component("utils"),
            "models": system.add_component("models")
        }
        
        # Simulate discovered relationships
        system.add_relation(components["main"], components["utils"])
        system.add_relation(components["main"], components["models"])
        system.add_relation(components["models"], components["utils"])
        system.add_relation(components["utils"], components["utils"], True)
        
        # Verify metrics
        assert system.calculate_cohesion() > 0.2
        assert system.calculate_coupling() < 0.8
        assert system.e_to_n_ratio() == 4/3  # ~1.33

    def test_cross_metric_integration(self, sample_system):
        """Test interaction between control flow and architecture"""
        # Add CFG complexity to components
        for component in sample_system.components:
            cfg = ControlFlowGraph()
            
            # Simulate different complexities
            if component['name'] == "database":
                # Complex DB component
                cfg.add_node('start', 'begin')
                cfg.add_node('predicate', 'if connected')
                cfg.add_node('procedure', 'query')
                cfg.add_edge(0, 1)
                cfg.add_edge(1, 2)
                component['complexity'] = cfg.calculate_complexity()
            else:
                # Simpler components
                component['complexity'] = 1
        
        # Verify complexity distribution
        db = next(c for c in sample_system.components if c['name'] == "database")
        assert db['complexity'] > 1
        assert sum(c['complexity'] for c in sample_system.components) > len(sample_system.components)

@pytest.mark.parametrize("components,relations,expected_depth", [
    (["A"], [], 0),                     # Single component
    (["A", "B"], [("A", "B")], 1),      # Linear
    (["A", "B", "C"], [("A", "B"), ("B", "C"), ("A", "C")], 2)  # Diamond
])
def test_depth_calculations(components, relations, expected_depth):
    """Parameterized test for morphology depth"""
    system = SoftwareSystem()
    comp_objs = {name: system.add_component(name) for name in components}
    
    for src, tgt in relations:
        system.add_relation(comp_objs[src], comp_objs[tgt])
    
    assert system.calculate_depth() == expected_depth