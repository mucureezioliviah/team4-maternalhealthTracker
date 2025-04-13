import pytest
from metrics.control_flow import calculate_cyclomatic_complexity

def test_simple_function():
    """Test complexity for linear code (1 path)"""
    assert calculate_cyclomatic_complexity(edges=1, nodes=2) == 1  # v = e - n + 2

def test_if_statement():
    """Test single conditional (2 paths)"""
    assert calculate_cyclomatic_complexity(edges=3, nodes=3) == 2

def test_predicate_nodes():
    """Test alternative calculation method"""
    assert calculate_cyclomatic_complexity(predicate_nodes=3) == 4  # v = 1 + d