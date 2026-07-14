import os
from langchain_community.document_loaders import DirectoryLoader, TextLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_google_genai import GoogleGenerativeAIEmbeddings
from langchain_community.vectorstores import Chroma
from dotenv import load_dotenv

load_dotenv()

def index_documents():
    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    kb_dir = os.path.join(os.path.dirname(base_dir), "knowledge_base")
    persist_dir = os.path.join(os.path.dirname(base_dir), "vector_db")

    print(f"Loading documents from {kb_dir}...")
    # Load txt files (can be extended to pdf using PyPDFLoader)
    loader = DirectoryLoader(kb_dir, glob="**/*.txt", loader_cls=TextLoader)
    documents = loader.load()

    if not documents:
        print("No documents found in knowledge_base.")
        return

    print(f"Loaded {len(documents)} documents. Splitting text...")
    text_splitter = RecursiveCharacterTextSplitter(chunk_size=500, chunk_overlap=50)
    texts = text_splitter.split_documents(documents)

    print(f"Creating vector store in {persist_dir}...")
    
    # Check if API Key is set
    if not os.getenv("GEMINI_API_KEY") or os.getenv("GEMINI_API_KEY") == "your_gemini_api_key_here":
        print("Warning: GEMINI_API_KEY is not set. Cannot generate embeddings.")
        return

    embeddings = GoogleGenerativeAIEmbeddings(model="models/embedding-001")

    vectorstore = Chroma.from_documents(
        documents=texts, 
        embedding=embeddings, 
        persist_directory=persist_dir
    )
    vectorstore.persist()
    print("Vector database successfully created and persisted.")

if __name__ == "__main__":
    index_documents()
