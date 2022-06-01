import { createContext } from "react";

// Context pour acceder au donnes depuis n'importe ou
const defaultContext = {
  lists: undefined,
  createList: undefined,
  deleteList: undefined,
  selectedList: undefined,
  setSelectedList: undefined,
  deleteTodo: undefined,
  updateTodo: undefined,
  createTodo: undefined,
};

const TodoContext = createContext(defaultContext);

export default TodoContext;
