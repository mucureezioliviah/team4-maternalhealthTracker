from metrics.control_flow import ControlFlowGraph
from fixtures.simple_function import sample_code

def test_cfg_construction():
    cfg = ControlFlowGraph()
    # Mock nodes representing a simple if-else
    start = cfg.add_node('start', 'begin')
    cond = cfg.add_node('predicate', 'if x > 0')
    true_branch = cfg.add_node('procedure', 'print("positive")')
    end = cfg.add_node('end', 'return')
    
    cfg.add_edge(start, cond)
    cfg.add_edge(cond, true_branch)  # True path
    cfg.add_edge(cond, end)          # False path
    cfg.add_edge(true_branch, end)
    
    assert cfg.calculate_complexity() == 2  # Expected for single if-else