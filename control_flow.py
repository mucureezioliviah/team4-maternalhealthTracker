class ControlFlowGraph:
    def __init__(self):
        self.nodes = []
        self.edges = []
        self.start_node = None
        self.end_nodes = []
    
    def add_node(self, node_type, statement=None):
        """Add node with type (procedure/predicate/start/end)"""
        node = {'id': len(self.nodes), 'type': node_type, 'statement': statement}
        self.nodes.append(node)
        return node
    
    def add_edge(self, from_node, to_node):
        """Add directed edge between nodes"""
        self.edges.append((from_node['id'], to_node['id']))
    
    def calculate_complexity(self):
        """Calculate cyclomatic complexity for this CFG"""
        predicate_nodes = sum(1 for n in self.nodes if n['type'] == 'predicate')
        return calculate_cyclomatic_complexity(
            len(self.edges),
            len(self.nodes),
            predicate_nodes=predicate_nodes
        )