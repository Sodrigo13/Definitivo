const express = require("express");
const router = express.Router();
const controllers = require("./controllers");

router.get("/notes", controllers.getNotes);
router.get("/notes/:id", controllers.getNoteById);
router.post("/notes", controllers.createNote);
router.put("/notes/:id", controllers.updateNote);
router.delete("/notes/:id", controllers.deleteNote);

module.exports = router;
