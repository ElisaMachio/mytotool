import * as React from "react";
import PropTypes from "prop-types";
import Box from "@mui/material/Box";
import CssBaseline from "@mui/material/CssBaseline";
import Divider from "@mui/material/Divider";
import Drawer from "@mui/material/Drawer";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import ListIcon from "@mui/icons-material/List";
import AccountMenu from "./AccountMenu";
import NewListButton from "./NewListButton";
import TodoContext from "../contexts/TodoContext";
import CloseIcon from "@mui/icons-material/Close";
import IconButton from "@mui/material/IconButton";

const drawerWidth = 240;

function ResponsiveDrawer(props) {
  const { window, children } = props;
  const [mobileOpen, setMobileOpen] = React.useState(false);
  const { lists, selectedList, setSelectedList, deleteList } =
    React.useContext(TodoContext);

  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen);
  };

  const drawer = (
    <div>
      <AccountMenu />
      <List>
        {lists.map((list, index) => (
          <ListItem
            selected={list.id === selectedList}
            key={list.id}
            disablePadding
          >
            <ListItemButton onClick={() => setSelectedList(list.id)}>
              <ListItemIcon>
                <ListIcon />
              </ListItemIcon>
              <ListItemText primary={list.title} />
            </ListItemButton>
            <ListItemButton onClick={() => deleteList(list.id)}>
              <IconButton>
                <CloseIcon />
              </IconButton>
            </ListItemButton>
          </ListItem>
        ))}
      </List>
      <Divider />
      <NewListButton />
    </div>
  );

  const container =
    window !== undefined ? () => window().document.body : undefined;

  return (
    <Box sx={{ display: "flex" }}>
      <CssBaseline />
      <Box
        component="nav"
        sx={{ width: { sm: drawerWidth }, flexShrink: { sm: 0 } }}
        aria-label="mailbox folders"
      >
        {/* The implementation can be swapped with js to avoid SEO duplication of links. */}
        <Drawer
          container={container}
          variant="temporary"
          open={mobileOpen}
          onClose={handleDrawerToggle}
          ModalProps={{
            keepMounted: true, // Better open performance on mobile.
          }}
          sx={{
            display: { xs: "block", sm: "none" },
            "& .MuiDrawer-paper": {
              boxSizing: "border-box",
              width: drawerWidth,
            },
          }}
        >
          {drawer}
        </Drawer>
        <Drawer
          variant="permanent"
          sx={{
            display: { xs: "none", sm: "block" },
            "& .MuiDrawer-paper": {
              boxSizing: "border-box",
              width: drawerWidth,
            },
          }}
          open
        >
          {drawer}
        </Drawer>
      </Box>
      <Box
        component="main"
        sx={{
          flexGrow: 1,
          p: 3,
          width: { sm: `calc(100% - ${drawerWidth}px)` },
        }}
      >
        {children}
      </Box>
    </Box>
  );
}

ResponsiveDrawer.propTypes = {
  window: PropTypes.func,
};

export default ResponsiveDrawer;
