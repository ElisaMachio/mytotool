import * as React from "react";
import { BACKEND_URL } from "../config";
import AuthContext from "../contexts/AuthContext";
import deleteData from "../utils/deleteData";
import postData from "../utils/postData";
import updateData from "../utils/updateData";

// Fonction pour gerer toute les requetes en lien avec les todolists et todos
function useTodoList() {
  const { token } = React.useContext(AuthContext);
  const [lists, setLists] = React.useState([]);
  const [selectedList, setSelectedList] = React.useState(1);

  // Met a jour le state de lists
  const updateLists = (response) => {
    let newLists = [...lists];
    let index = lists.findIndex((list) => list.id === response.id);
    if (index !== -1) {
      newLists[index] = response;
    } else {
      newLists.push(response);
    }
    setLists(newLists);
  };

  // Recupere les todolists
  const fetchNewLists = () => {
    postData(`${BACKEND_URL}/user/me`, { token: token }).then((data) => {
      if (Object.keys(data).length !== 0) {
        setLists(data.todoLists);
        setSelectedList(data.todoLists[0].id);
      }
    });
  };

  React.useEffect(() => {
    if (token !== undefined) {
      fetchNewLists();
    }
  }, [token]);

  // Creer une liste
  const createList = (title) => {
    postData(`${BACKEND_URL}/list`, {
      token,
      title,
    }).then((response) => {
      updateLists(response);
    });
  };

  // Supprime une liste
  const deleteList = (id) => {
    deleteData(`${BACKEND_URL}/list`, {
      id,
      token,
    }).then((response) => {
      fetchNewLists();
    });
  };

  // Creer un todo
  const createTodo = (value, todoListId) => {
    postData(`${BACKEND_URL}/list/todo`, {
      token,
      value,
      todoListId,
    }).then((response) => {
      updateLists(response);
    });
  };

  // Met a jour un todo
  const updateTodo = (id, value, isDone) => {
    console.log(id, value, isDone);
    updateData(`${BACKEND_URL}/list/todo`, {
      token,
      id,
      value,
      isDone,
      todoListId: selectedList,
    }).then((response) => {
      updateLists(response);
    });
  };

  // Delete un todo
  const deleteTodo = (id) => {
    deleteData(`${BACKEND_URL}/list/todo`, {
      id,
    }).then((response) => {
      updateLists(response);
    });
  };

  return {
    createTodo,
    updateTodo,
    deleteTodo,
    lists,
    createList,
    deleteList,
    selectedList,
    setSelectedList,
  };
}

export default useTodoList;
