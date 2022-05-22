import { useState } from "react";
import { BACKEND_URL } from "../config";
import postData from "../utils/postData";
import useStorage from "./useStorage";

function useAuthentication() {
  const [user, updateUser, deleteUser] = useStorage("user");
  const [token, updateToken, deleteToken] = useStorage("user_token");

  const signIn = (username, password) => {
    postData(`${BACKEND_URL}/auth/login`, {
      username,
      password,
    }).then((response) => {
      updateUser(JSON.stringify(response));
      updateToken(response.token);
    });
  };

  const signUp = (username, password) => {
    postData(`${BACKEND_URL}/auth/register`, {
      username,
      password,
    }).then((data) => console.log(data));
  };

  const logout = () => {
    deleteToken();
    deleteUser();
  };

  return {
    logout,
    user,
    token,
    signIn,
    signUp,
  };
}

export default useAuthentication;
