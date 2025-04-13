import pytest
from pygls.lsp.methods import TEXT_DOCUMENT_DID_OPEN
from metrics.extension import create_lsp_server

@pytest.mark.asyncio
async def test_document_analysis():
    server = create_lsp_server()
    
    # Simulate VS Code opening a file
    params = {
        "textDocument": {
            "uri": "file:///test.py",
            "text": "def foo():\n    if x > 0:\n        pass"
        }
    }
    await server.lsp.notify(TEXT_DOCUMENT_DID_OPEN, params)
    
    # Check if complexity warning was generated
    assert any(diag.message == "High cyclomatic complexity" 
               for diag in server.publish_diagnostics.call_args[0][0])