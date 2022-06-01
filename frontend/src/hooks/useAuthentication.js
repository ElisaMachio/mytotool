import * as React from "react";
import { BACKEND_URL } from "../config";
import postData from "../utils/postData";
import useStorage from "./useStorage";

// Hook avec qui permet l'authentification de l'utilisateur
function useAuthentication() {
  const [user, setUser] = React.useState();
  // stock le token dans le navigateur
  const [token, updateToken, deleteToken] = useStorage("user_token");

  // Recuepere les donnes de l'utilisteur si token a jour
  React.useEffect(() => {
    if (token !== undefined) {
      postData(`${BACKEND_URL}/user/me`, { token: token })
        .then((data) => {
          if (Object.keys(data).length !== 0) {
            setUser(data);
          } else {
            logout();
          }
        })
        .catch(() => logout());
    }
  }, [token]);

  // Fonction pour se connecter
  const signIn = (username, password) => {
    postData(`${BACKEND_URL}/auth/login`, {
      username,
      password,
    }).then((response) => {
      setUser(JSON.stringify(response));
      updateToken(response.token);
    });
  };

  // Fonction pour s'enregistrer
  const signUp = (username, password) => {
    postData(`${BACKEND_URL}/auth/register`, {
      username,
      password,
    }).then((data) => console.log(data));
  };

  const logout = () => {
    deleteToken();
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
