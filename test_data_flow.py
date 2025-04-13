"""
Unit tests for data flow metrics:
- Data structure complexity
- Information flow complexity (fan-in/fan-out)
- Global vs local data usage
- Data coupling patterns
"""

import pytest
from metrics.data_flow import DataFlowAnalyzer, calculate_data_complexity

class TestDataStructureComplexity:
    def test_primitive_types(self):
        """Test complexity for basic data types"""
        assert calculate_data_complexity(
            integers=3,    # 3 × 1 = 3
            strings=0,     # 0 × 2 = 0
            arrays=[]      # No arrays
        ) == 3

    def test_string_handling(self):
        """Test string complexity weighting"""
        assert calculate_data_complexity(
            integers=1,    # 1 × 1 = 1
            strings=4,     # 4 × 2 = 8
            arrays=[]      # No arrays
        ) == 9

    def test_array_complexity(self):
        """Test array complexity calculation"""
        assert calculate_data_complexity(
            integers=0,
            strings=0,
            arrays=[5, 10]  # 2 arrays: 5×2 + 10×2 = 30
        ) == 30

    def test_mixed_structures(self):
        """Combined complexity score"""
        assert calculate_data_complexity(
            integers=2,     # 2 × 1 = 2
            strings=3,      # 3 × 2 = 6
            arrays=[4, 8]   # 4×2 + 8×2 = 24
        ) == 32

class TestInformationFlow:
    @pytest.fixture
    def flow_analyzer(self):
        analyzer = DataFlowAnalyzer()
        
        # Setup test modules
        analyzer.add_module("auth", length=50)
        analyzer.add_module("db", length=30)
        analyzer.add_module("api", length=80)
        
        return analyzer

    def test_fan_in_calculation(self, flow_analyzer):
        """Test incoming data flow counting"""
        flow_analyzer.add_call("auth", "db")    # db fan-in +1
        flow_analyzer.add_call("api", "db")     # db fan-in +1
        flow_analyzer.add_data_access("auth", "users_table")
        
        assert flow_analyzer.modules["db"]["fan_in"] == 2
        assert flow_analyzer.modules["auth"]["fan_in"] == 0

    def test_fan_out_calculation(self, flow_analyzer):
        """Test outgoing data flow counting"""
        flow_analyzer.add_call("auth", "db")
        flow_analyzer.add_call("auth", "api")
        flow_analyzer.add_data_update("auth", "session_cache")
        
        assert flow_analyzer.modules["auth"]["fan_out"] == 3  # 2 calls + 1 update
        assert flow_analyzer.modules["db"]["fan_out"] == 0

    def test_data_structure_handling(self, flow_analyzer):
        """Test shared data structure tracking"""
        flow_analyzer.add_data_access("auth", "user_profiles")
        flow_analyzer.add_data_update("db", "user_profiles")  # Same structure
        flow_analyzer.add_data_access("api", "product_catalog")
        
        assert len(flow_analyzer.modules["auth"]["data_structures_accessed"]) == 1
        assert len(flow_analyzer.modules["db"]["data_structures_updated"]) == 1
        assert "user_profiles" in flow_analyzer.shared_data_structures

    def test_information_flow_complexity(self, flow_analyzer):
        """Test Henry-Kafura IFC calculation"""
        flow_analyzer.add_call("auth", "db")
        flow_analyzer.add_call("api", "db")
        flow_analyzer.add_data_access("auth", "config")
        flow_analyzer.add_data_update("db", "user_data")
        
        # auth: fan_in=0, fan_out=2 (1 call + 1 access)
        # db: fan_in=2, fan_out=1 (1 update)
        assert flow_analyzer.calculate_information_flow("auth") == (0 * 2) ** 2  # 0
        assert flow_analyzer.calculate_information_flow("db") == (2 * 1) ** 2    # 4

    def test_shepperd_ifc_variant(self, flow_analyzer):
        """Test simplified IFC calculation (without length)"""
        flow_analyzer.add_call("main", "auth")
        flow_analyzer.add_call("main", "db")
        flow_analyzer.add_data_access("main", "global_config")
        
        # main: fan_in=0, fan_out=3
        ifc = (0 * 3) ** 2
        assert flow_analyzer.calculate_information_flow("main", use_length=False) == ifc

class TestSpecialCases:
    def test_recursive_calls(self):
        """Test handling of recursive data flow"""
        analyzer = DataFlowAnalyzer()
        analyzer.add_module("math", length=20)
        analyzer.add_call("math", "math")  # Recursive call
        
        assert analyzer.modules["math"]["fan_in"] == 1
        assert analyzer.modules["math"]["fan_out"] == 1
        assert analyzer.calculate_information_flow("math") == 1  # (1×1)²

    def test_global_data_flow(self):
        """Test tracking of global variable access"""
        analyzer = DataFlowAnalyzer()
        analyzer.add_module("config", length=10)
        analyzer.add_module("app", length=50)
        
        analyzer.add_data_access("app", "GLOBAL_CONFIG")
        analyzer.add_data_update("config", "GLOBAL_CONFIG")
        
        assert "GLOBAL_CONFIG" in analyzer.shared_data_structures
        assert analyzer.modules["app"]["fan_out"] == 1  # Data access counts

    def test_duplicate_flows(self):
        """Ensure duplicate flows don't double-count"""
        analyzer = DataFlowAnalyzer()
        analyzer.add_module("logger", length=15)
        
        analyzer.add_call("logger", "file_system")
        analyzer.add_call("logger", "file_system")  # Duplicate
        
        assert analyzer.modules["logger"]["fan_out"] == 1  # Only unique counts

@pytest.mark.parametrize("fan_in,fan_out,expected_ifc", [
    (0, 0, 0),     # No flow
    (1, 0, 0),     # Only incoming
    (0, 1, 0),     # Only outgoing
    (1, 1, 1),     # Balanced
    (3, 2, 36),    # (3×2)² = 36
    (5, 0, 0)      # Edge case
])
def test_ifc_matrix(fan_in, fan_out, expected_ifc):
    """Parameterized test for IFC formula variations"""
    analyzer = DataFlowAnalyzer()
    analyzer.add_module("test", length=10)
    
    # Mock the flow counts
    analyzer.modules["test"]["fan_in"] = fan_in
    analyzer.modules["test"]["fan_out"] = fan_out
    
    assert analyzer.calculate_information_flow("test", use_length=False) == expected_ifc