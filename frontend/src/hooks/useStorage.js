import { useEffect, useState } from "react";

const useStorage = (storageKey) => {
  const [value, setValue] = useState();

  useEffect(() => {
    setValue(localStorage.getItem(storageKey) || "");
  }, []);

  const updateValue = async (newValue) => {
    try {
      console.log(newValue);
      localStorage.setItem(storageKey, newValue);
      setValue(newValue);
    } catch (err) {
      console.error(err);
    }
  };

  const clearValue = async () => {
    try {
      localStorage.clear();
      setValue("");
    } catch (err) {
      console.error(err);
    }
  };

  return [value, updateValue, clearValue];
};

export default useStorage;
