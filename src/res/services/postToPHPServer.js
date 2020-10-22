import Api from './API'

export default {
  send(credentials){//  '@/server/command.php'
    const formData = credentials;
    // formData.append('withCredentials', 'true');
    return Api().post('/index.php', formData )
  }
}

// const formData = new FormData();
// formData.append('command', 'Login');
//
// await postToPHPServer.send(formData)
//   .then(res => {
//     if (res.status === 200) {
//       let dataJ = res.data;
//
//     }
//   })
//   .catch(error => {
//     alert(error);
//   });
