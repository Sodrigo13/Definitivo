document.addEventListener("DOMContentLoaded", fetchNotes);

async function fetchNotes() {
    const response = await fetch("http://localhost:3000/notes");
    const notes = await response.json();
    
    const notesList = document.getElementById("notes-list");
    notesList.innerHTML = "";
    
    notes.forEach(note => {
        const li = document.createElement("li");
        li.textContent = `${note.title}: ${note.content}`;
        notesList.appendChild(li);
    });
}

async function createNote() {
    const title = document.getElementById("title").value;
    const content = document.getElementById("content").value;
    
    if (!title || !content) {
        alert("Preencha todos os campos!");
        return;
    }
    
    await fetch("http://localhost:3000/notes", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title, content })
    });

    fetchNotes();
}
