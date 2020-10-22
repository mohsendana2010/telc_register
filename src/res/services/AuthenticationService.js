import Api from './Api'

export default {
  register (credentials) {
    return Api().post('register', credentials)
  },
  check(credentials){
    return Api().post('/command.php', credentials)
  },
  login (credentials) {
    return Api().post('login', credentials)
  }
}