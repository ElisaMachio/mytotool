import ResponsiveDrawer from "../components/ResponsiveDrawer";
import TodoList from "../components/TodoList";
import TodoProvider from "../providers/TodoProvider";

// Page principale de l'application
function MyToTool() {
  return (
    <TodoProvider>
      <ResponsiveDrawer>
        <TodoList />
      </ResponsiveDrawer>
    </TodoProvider>
  );
}

export default MyToTool;
