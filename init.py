"""
Metrics - Software quality measurement toolkit

Exposes core functionality for:
- Control flow analysis
- Architectural metrics
- Data flow tracking
"""

# Core exports
from .control_flow import (
    ControlFlowGraph,
    calculate_cyclomatic_complexity,
    find_depth_of_nesting
)
from .architecture import (
    SoftwareSystem,
    calculate_cohesion,
    calculate_coupling
)
from .data_flow import (
    DataFlowAnalyzer,
    calculate_data_complexity,
    InformationFlowComplexity
)

# Version
__version__ = "1.0.0"

# Public API
__all__ = [
    # Control flow
    'ControlFlowGraph',
    'calculate_cyclomatic_complexity',
    'find_depth_of_nesting',
    
    # Architecture
    'SoftwareSystem',
    'calculate_cohesion', 
    'calculate_coupling',
    
    # Data flow
    'DataFlowAnalyzer',
    'calculate_data_complexity',
    'InformationFlowComplexity',
    
    # Version
    '__version__'
]