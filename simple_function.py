"""
Simple function fixture for testing baseline metrics:
- Linear control flow
- Minimal branching
- Basic data structures
- Single responsibility
"""

def calculate_average(numbers):
    """
    Computes the arithmetic mean of a number list
    Args:
        numbers: List of numeric values
    Returns:
        float: Arithmetic mean
    Raises:
        ValueError: If input is empty
    """
    if not numbers:
        raise ValueError("Input list cannot be empty")
    
    total = sum(numbers)
    return total / len(numbers)


def is_positive(number):
    """
    Checks if a number is positive
    Args:
        number: Numeric value
    Returns:
        bool: True if positive, False otherwise
    """
    return number > 0


def format_name(first, last):
    """
    Combines first and last names
    Args:
        first: First name string
        last: Last name string
    Returns:
        str: Formatted full name
    """
    return f"{first.strip()} {last.strip()}"


class SimpleCounter:
    """Basic counter with increment/decrement"""
    
    def __init__(self):
        self.value = 0
    
    def increment(self, amount=1):
        """Increase counter value"""
        self.value += amount
    
    def decrement(self, amount=1):
        """Decrease counter value"""
        self.value = max(0, self.value - amount)
    
    def reset(self):
        """Reset to zero"""
        self.value = 0


# Example module-level constant
DEFAULT_THRESHOLD = 10


def check_threshold(value):
    """Compares value against default threshold"""
    return value > DEFAULT_THRESHOLD