import * as React from "react";
import Box from "@mui/material/Box";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import AddCircleOutlineIcon from "@mui/icons-material/AddCircleOutline";
import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import Modal from "@mui/material/Modal";
import { TextField } from "@mui/material";
import TodoContext from "../contexts/TodoContext";

const style = {
  position: "absolute",
  top: "50%",
  left: "50%",
  transform: "translate(-50%, -50%)",
  width: 400,
  bgcolor: "background.paper",
  boxShadow: 24,
  p: 4,
};

function NewListButton() {
  const { createList } = React.useContext(TodoContext);
  const [open, setOpen] = React.useState(false);
  const [value, setValue] = React.useState("");
  const handleOpen = () => setOpen(true);
  const handleClose = () => setOpen(false);

  return (
    <>
      <ListItem key={"Creer une liste"} disablePadding>
        <ListItemButton onClick={() => handleOpen()}>
          <ListItemIcon>
            <AddCircleOutlineIcon />
          </ListItemIcon>
          <ListItemText primary={"Creer une liste"} />
        </ListItemButton>
      </ListItem>
      <Modal
        open={open}
        onClose={handleClose}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <Typography id="modal-modal-title" variant="h6" component="h2">
            Text in a modal
          </Typography>
          <TextField
            value={value}
            onChange={(event) => setValue(event.target.value)}
            sx={{ marginTop: 2, width: "100%" }}
            label="Nom de la liste"
            variant="standard"
          />
          <br />
          <Button
            onClick={() => {
              handleClose();
              createList(value);
            }}
            variant="contained"
            sx={{ marginTop: 2 }}
          >
            Creer
          </Button>
        </Box>
      </Modal>
    </>
  );
}

export default NewListButton;
