import useAuthentication from "../hooks/useAuthentication";
import React from "react";
import TodoContext from "../contexts/TodoContext";
import useTodoList from "../hooks/useTodoList";

// Mis en place du context via le provider
const TodoProvider = ({ children }) => {
  const {
    lists,
    createList,
    selectedList,
    setSelectedList,
    deleteTodo,
    updateTodo,
    createTodo,
    deleteList,
  } = useTodoList();

  return (
    <TodoContext.Provider
      value={{
        lists,
        createList,
        deleteList,
        selectedList,
        setSelectedList,
        deleteTodo,
        updateTodo,
        createTodo,
      }}
    >
      {children}
    </TodoContext.Provider>
  );
};

export default TodoProvider;
