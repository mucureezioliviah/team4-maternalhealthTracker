"""
Complex module fixture testing:
- Nested control structures
- Multiple branching paths
- Mixed data structures
- Function calls
"""

class DataProcessor:
    def __init__(self, config):
        self.config = config
        self.cache = {}
        self.stats = {
            'processed': 0,
            'errors': []
        }

    def process_data(self, input_data, retry_count=0):
        """Main processing method with multiple complexity factors"""
        result = None
        
        # First level if-else
        if not self._validate_input(input_data):
            self.stats['errors'].append("Invalid input")
            return None