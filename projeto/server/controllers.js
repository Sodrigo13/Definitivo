const db = require("./database");

exports.getNotes = (req, res) => {
    db.all("SELECT * FROM notes", [], (err, rows) => {
        if (err) res.status(500).json({ error: err.message });
        else res.json(rows);
    });
};

exports.getNoteById = (req, res) => {
    const { id } = req.params;
    db.get("SELECT * FROM notes WHERE id = ?", [id], (err, row) => {
        if (err) res.status(500).json({ error: err.message });
        else if (!row) res.status(404).json({ message: "Nota não encontrada" });
        else res.json(row);
    });
};

exports.createNote = (req, res) => {
    const { title, content } = req.body;
    db.run("INSERT INTO notes (title, content) VALUES (?, ?)", [title, content], function (err) {
        if (err) res.status(500).json({ error: err.message });
        else res.status(201).json({ id: this.lastID, title, content });
    });
};

exports.updateNote = (req, res) => {
    const { id } = req.params;
    const { title, content } = req.body;
    db.run("UPDATE notes SET title = ?, content = ? WHERE id = ?", [title, content, id], function (err) {
        if (err) res.status(500).json({ error: err.message });
        else if (this.changes === 0) res.status(404).json({ message: "Nota não encontrada" });
        else res.json({ id, title, content });
    });
};

exports.deleteNote = (req, res) => {
    const { id } = req.params;
    db.run("DELETE FROM notes WHERE id = ?", [id], function (err) {
        if (err) res.status(500).json({ error: err.message });
        else if (this.changes === 0) res.status(404).json({ message: "Nota não encontrada" });
        else res.json({ message: "Nota excluída com sucesso" });
    });
};
