import * as React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";
import CloseIcon from "@mui/icons-material/Close";
import Checkbox from "@mui/material/Checkbox";
import IconButton from "@mui/material/IconButton";

const label = { inputProps: { "aria-label": "Checkbox demo" } };

function TodoItem() {
  const [focus, setFocus] = React.useState(false);

  return (
    <>
      <Box
        sx={{
          backgroundColor: focus ? "#eeeeee" : "",
          borderRadius: 2,
          display: "flex",
          alignItems: "flex-end",
        }}
      >
        <Checkbox {...label} />
        <TextField
          onFocus={() => setFocus(true)}
          onBlur={() => setFocus(false)}
          InputProps={{
            disableUnderline: true,
          }}
          sx={{ width: 600, paddingBottom: "4px" }}
          variant="standard"
        />
        <IconButton aria-label="Delete todo">
          <CloseIcon />
        </IconButton>
      </Box>
    </>
  );
}

export default TodoItem;
