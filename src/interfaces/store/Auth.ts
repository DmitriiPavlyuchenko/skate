export interface IAuth {
  token: string;
  refreshToken: string;
  role: string;
  isAuth: boolean;
}

export interface IAuthorizationData {
  email: string;
  password: string;
}
