import axios from "axios";

export const getNews = async (URL: string): Promise<object> => {
  return await axios.get(URL);
};
