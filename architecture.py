class SoftwareSystem:
    def __init__(self):
        self.components = []
        self.relations = []
    
    def add_component(self, name):
        component = {'name': name, 'internal_relations': 0}
        self.components.append(component)
        return component
    
    def add_relation(self, source, target, is_internal=False):
        """Add relation between components"""
        relation = {'source': source, 'target': target, 'internal': is_internal}
        self.relations.append(relation)
        
        # Update component stats
        if is_internal:
            source['internal_relations'] += 1
            target['internal_relations'] += 1
    
    def calculate_cohesion(self):
        """Calculate system cohesion as average component cohesion"""
        total_cohesion = 0
        for component in self.components:
            internal = component['internal_relations']
            external = sum(1 for r in self.relations 
                          if (r['source'] == component or r['target'] == component) 
                          and not r['internal'])
            total = internal + external
            cohesion = internal / total if total > 0 else 0
            total_cohesion += cohesion
        
        return total_cohesion / len(self.components) if self.components else 0
    
    def calculate_coupling(self):
        """Calculate system coupling as average component coupling"""
        total_coupling = 0
        for component in self.components:
            internal = component['internal_relations']
            external = sum(1 for r in self.relations 
                          if (r['source'] == component or r['target'] == component) 
                          and not r['internal'])
            total = internal + external
            coupling = external / total if total > 0 else 0
            total_coupling += coupling
        
        return total_coupling / len(self.components) if self.components else 0