export interface authInterface {
    email: string
    password: string
    isRemember: boolean
}

export interface tokenInterface {
    accessToken: string,
    typeToken: string,
    expiresIn: number,
}
