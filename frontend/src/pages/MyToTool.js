import ResponsiveDrawer from "../components/ResponsiveDrawer";
import TodoList from "../components/TodoList";

function MyToTool() {
  return (
    <ResponsiveDrawer>
      <TodoList id={1} />
    </ResponsiveDrawer>
  );
}

export default MyToTool;
