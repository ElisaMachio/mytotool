import ResponsiveDrawer from "../components/ResponsiveDrawer";
import TodoList from "../components/TodoList";
import TodoProvider from "../providers/TodoProvider";

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
