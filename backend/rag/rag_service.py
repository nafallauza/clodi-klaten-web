import os
from langchain_google_genai import ChatGoogleGenerativeAI, GoogleGenerativeAIEmbeddings
from langchain_community.vectorstores import Chroma
from langchain.chains import RetrievalQA
from langchain.prompts import PromptTemplate
from dotenv import load_dotenv

load_dotenv()

def get_rag_answer(query: str, cv_results: dict) -> str:
    """
    RAG service for handling user consultation queries using Gemini API.
    Retrieves context from ChromaDB based on the user query.
    """
    if not os.getenv("GEMINI_API_KEY") or os.getenv("GEMINI_API_KEY") == "your_gemini_api_key_here":
        # Mock Response
        return "Halo! Ini adalah respons simulasi (Mock Response) karena GEMINI_API_KEY belum dikonfigurasi. Berdasarkan analisis wajah Anda, saya merekomendasikan penggunaan Niacinamide dan menjaga kebersihan wajah secara teratur. Jika kondisi memburuk, segera hubungi dokter."

    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    persist_dir = os.path.join(os.path.dirname(base_dir), "vector_db")

    try:
        embeddings = GoogleGenerativeAIEmbeddings(model="models/embedding-001")
        vectorstore = Chroma(persist_directory=persist_dir, embedding_function=embeddings)
        retriever = vectorstore.as_retriever(search_kwargs={"k": 3})

        llm = ChatGoogleGenerativeAI(model="gemini-1.5-pro-latest", temperature=0.3)

        prompt_template = """
        Anda adalah seorang Dermatologist AI (Agentic Skincare AI). 
        Gunakan konteks medis berikut untuk menjawab pertanyaan pengguna. 
        TIDAK BOLEH menjawab informasi medis di luar konteks yang diberikan. 
        Jika jawaban tidak ada dalam konteks, katakan bahwa Anda tidak memiliki informasi tersebut dan sarankan untuk menemui dokter spesialis kulit.

        Konteks Medis:
        {context}

        Kondisi Pasien (Hasil Analisis Wajah):
        Tingkat Keparahan: {severity}
        Masalah Terdeteksi: {issues}

        Pertanyaan Pasien: {question}

        Jawaban Dermatologist AI:
        """

        PROMPT = PromptTemplate(
            template=prompt_template, 
            input_variables=["context", "question"]
        )
        PROMPT = PROMPT.partial(
            severity=cv_results.get('severity', 'Tidak diketahui'),
            issues=", ".join(cv_results.get('detected_issues', ['Tidak diketahui']))
        )

        qa_chain = RetrievalQA.from_chain_type(
            llm=llm,
            chain_type="stuff",
            retriever=retriever,
            return_source_documents=False,
            chain_type_kwargs={"prompt": PROMPT}
        )

        result = qa_chain.invoke({"query": query})
        return result["result"]

    except Exception as e:
        print(f"RAG Error: {e}")
        return "Maaf, terjadi kesalahan pada sistem AI saat memproses data knowledge base. Pastikan API Key valid dan database vektor telah diinisialisasi."
