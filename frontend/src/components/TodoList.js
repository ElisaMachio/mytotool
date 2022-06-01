import { Button, Grid, Typography } from "@mui/material";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import { useContext, useState } from "react";
import TodoItem from "./TodoItem";
import AddCircleOutlineIcon from "@mui/icons-material/AddCircleOutline";
import TodoContext from "../contexts/TodoContext";

// Affiche le nom de la todolist et les lignes des todos
function TodoList() {
  const { lists, selectedList, createTodo } = useContext(TodoContext);

  const todos = lists.find((value) => value.id === selectedList)?.todos;

  return (
    <Grid container spacing={2}>
      <Grid item xs={12} sx={{ marginBottom: 1 }}>
        <Typography sx={{ float: "left" }} variant="h4">
          Todo title
        </Typography>
      </Grid>
      <Grid item sx={12}>
        {todos &&
          todos.map((todo) => (
            <TodoItem
              id={todo.id}
              text={todo.value}
              defaultIsDone={todo.isDone}
            />
          ))}
        <ListItem key={"Ajouter un todo"} disablePadding>
          <ListItemButton
            onClick={() => createTodo("", selectedList)}
            sx={{ borderRadius: 2 }}
          >
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
