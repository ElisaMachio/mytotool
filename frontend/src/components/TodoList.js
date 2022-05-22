import { Button, Grid, Typography } from "@mui/material";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import { useState } from "react";
import TodoItem from "./TodoItem";
import AddCircleOutlineIcon from "@mui/icons-material/AddCircleOutline";

const testTodos = [
  {
    id: 1,
    text: "I am a todo",
    done: false,
  },
  {
    id: 2,
    text: "I am a todo",
    done: false,
  },
  {
    id: 3,
    text: "I am a todo",
    done: true,
  },
  {
    id: 4,
    text: "I am a todo",
    done: false,
  },
];

function TodoList({ id }) {
  const [todos, setTodos] = useState(testTodos);

  return (
    <Grid container spacing={2}>
      <Grid item xs={12} sx={{ marginBottom: 1 }}>
        <Typography sx={{ float: "left" }} variant="h4">
          Todo title
        </Typography>
      </Grid>
      <Grid item sx={12}>
        {todos.map((todo) => (
          <TodoItem id={todo.id} text={todo.text} done={todo.done} />
        ))}
        <ListItem key={"Ajouter un todo"} disablePadding>
          <ListItemButton sx={{ borderRadius: 2 }}>
            <ListItemIcon>
              <AddCircleOutlineIcon />
            </ListItemIcon>
            <ListItemText primary={"Ajouter un todo"} />
          </ListItemButton>
        </ListItem>
      </Grid>
    </Grid>
  );
}

export default TodoList;
