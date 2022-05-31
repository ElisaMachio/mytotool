import * as React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";
import CloseIcon from "@mui/icons-material/Close";
import Checkbox from "@mui/material/Checkbox";
import IconButton from "@mui/material/IconButton";
import TodoContext from "../contexts/TodoContext";

const label = { inputProps: { "aria-label": "Checkbox demo" } };

function TodoItem({ id, text, defaultIsDone }) {
  const [focus, setFocus] = React.useState(false);
  const [isDone, setIsDone] = React.useState(defaultIsDone);
  const [textValue, setTextValue] = React.useState(text);
  const { deleteTodo, updateTodo } = React.useContext(TodoContext);

  const handleFocus = () => {
    setFocus(true);
  };

  const handleBlur = () => {
    setFocus(false);
    updateTodo(id, textValue, isDone);
  };

  // React.useEffect(() => {
  //   updateTodo(id, textValue, isDone);
  // }, [id, textValue, isDone]);

  return (
    <>
      <Box
        key={id}
        sx={{
          backgroundColor: focus ? "#eeeeee" : "",
          borderRadius: 2,
          display: "flex",
          alignItems: "flex-end",
        }}
      >
        <Checkbox
          defaultChecked={defaultIsDone}
          onChange={(value) => {
            setIsDone(value.target.checked);
            handleBlur();
          }}
          {...label}
        />
        <TextField
          onChange={(value) => setTextValue(value.target.value)}
          defaultValue={text}
          onFocus={() => handleFocus()}
          onBlur={() => handleBlur()}
          InputProps={{
            disableUnderline: true,
          }}
          sx={{ width: 600, paddingBottom: "4px" }}
          variant="standard"
        />
        <IconButton onClick={() => deleteTodo(id)} aria-label="Delete todo">
          <CloseIcon />
        </IconButton>
      </Box>
    </>
  );
}

export default TodoItem;
