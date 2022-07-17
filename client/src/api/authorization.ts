import axios from "axios";

export const signIn = async (URL: string, data: object): Promise<object> => {
  return await axios.post(URL, data);
};

export const signUp = async (URL: string, data: object): Promise<object> => {
  return await axios.post(URL, data);
};
