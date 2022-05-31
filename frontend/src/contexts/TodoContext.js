import { createContext } from "react";

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
