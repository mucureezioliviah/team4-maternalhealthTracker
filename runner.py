"""
Main execution runner for software metrics analysis
Handles:
- File system traversal
- Tool orchestration
- Output generation
- Threshold enforcement
"""

import argparse
import json
import sys
from pathlib import Path
from typing import Dict, Any

# Local imports
from .control_flow import ControlFlowGraph, calculate_cyclomatic_complexity
from .architecture import SoftwareSystem
from .data_flow import DataFlowAnalyzer

class MetricRunner:
    def __init__(self, config: Dict[str, Any] = None):
        self.config = config or {
            'complexity_threshold': 10,
            'cohesion_threshold': 0.5,
            'coupling_threshold': 0.7
        }
        self.system = SoftwareSystem()
        self.data_flow = DataFlowAnalyzer()

    def analyze_file(self, file_path: Path):
        """Analyze a single source file"""
        with open(file_path, 'r') as f:
            source = f.read()

        # Control flow analysis
        cfg = ControlFlowGraph.build_from_source(source)
        complexity = cfg.calculate_complexity()

        # Architectural analysis
        component = self.system.add_component(file_path.stem)
        self._register_imports(component, source)

        # Data flow analysis
        self.data_flow.add_module(file_path.stem, len(source.splitlines()))
        self._analyze_data_flow(file_path.stem, source)

        return {
            'file': str(file_path),
            'complexity': complexity,
            'line_count': len(source.splitlines()),
            'components': [file_path.stem]
        }

    def _register_imports(self, component, source: str):
        """Extract imports for architectural analysis"""
        # Simplified import parsing - would use AST in production
        for line in source.splitlines():
            if line.startswith(('import ', 'from ')):
                module = line.split()[1].split('.')[0]
                self.system.add_relation(component, module)

    def _analyze_data_flow(self, module_name: str, source: str):
        """Extract data flow patterns"""
        # Placeholder - would use AST analysis in real implementation
        if 'open(' in source:
            self.data_flow.add_data_access(module_name, 'file_system')
        if 'import sqlite3' in source:
            self.data_flow.add_data_update(module_name, 'database')

    def analyze_directory(self, path: Path):
        """Recursively analyze a directory"""
        results = []
        for py_file in path.rglob('*.py'):
            if not self._should_skip(py_file):
                results.append(self.analyze_file(py_file))

        # Calculate system-wide metrics
        system_metrics = {
            'cohesion': self.system.calculate_cohesion(),
            'coupling': self.system.calculate_coupling(),
            'data_flow': self.data_flow.calculate_global_metrics()
        }

        return {
            'files': results,
            'system': system_metrics,
            'thresholds': self.config
        }

    def _should_skip(self, file_path: Path) -> bool:
        """Determine if file should be excluded"""
        skip_dirs = {'tests', 'migrations', '__pycache__'}
        return any(part in skip_dirs for part in file_path.parts)

def main():
    """Command line interface"""
    parser = argparse.ArgumentParser(
        description='Software Metrics Analyzer',
        formatter_class=argparse.ArgumentDefaultsHelpFormatter
    )
    parser.add_argument('path', help='File or directory to analyze')
    parser.add_argument(
        '--output', 
        choices=['json', 'text', 'csv'], 
        default='text',
        help='Output format'
    )
    parser.add_argument(
        '--threshold', 
        type=int,
        default=10,
        help='Cyclomatic complexity warning threshold'
    )
    args = parser.parse_args()

    runner = MetricRunner({
        'complexity_threshold': args.threshold
    })
    path = Path(args.path)

    if path.is_file():
        results = runner.analyze_file(path)
    else:
        results = runner.analyze_directory(path)

    # Generate output
    if args.output == 'json':
        print(json.dumps(results, indent=2))
    else:
        _print_text_report(results)

def _print_text_report(results: Dict):
    """Human-readable output"""
    print(f"\n{' Software Metrics Report ':=^60}\n")
    
    # File-level metrics
    if 'files' in results:
        print("File Analysis:")
        for file in results['files']:
            status = "⚠️" if file['complexity'] > 10 else "✓"
            print(f"{status} {file['file']}:")
            print(f"  - Complexity: {file['complexity']}")
            print(f"  - Lines: {file['line_count']}")

    # System-wide metrics
    if 'system' in results:
        print("\nSystem Overview:")
        print(f"- Cohesion: {results['system']['cohesion']:.2f} (ideal > 0.5)")
        print(f"- Coupling: {results['system']['coupling']:.2f} (ideal < 0.7)")
        print(f"- Data Flow Complexity: {results['system']['data_flow']}")

if __name__ == '__main__':
    main()