import subprocess
from unittest.mock import patch

def test_cli_analysis():
    result = subprocess.run(
        ['python', '-m', 'metrics.cli', 'analyze', 'src/'],
        capture_output=True,
        text=True
    )
    assert "Cyclomatic complexity" in result.stdout
    assert result.returncode == 0