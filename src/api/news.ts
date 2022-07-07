import axios from "axios";

export const getNews = async (URL: string): Promise<object> => {
  return await axios.get(URL);
};

export const getNewsItemInformation = async (
  URL: string,
  id: string
): Promise<object> => {
  const urlItem = URL + "/" + id;
  return await axios.get(urlItem);
};
