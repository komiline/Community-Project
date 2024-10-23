import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

import express from "express";

const app = express();
const port = 3000;

app.use(express.static('project'));

app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'project', 'Main.html'));
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
