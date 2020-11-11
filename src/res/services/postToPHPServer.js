import Api from './API'

export default {
  send(credentials){//  '@/server/command.php'
    return new Promise((resolve, reject) => {
      const formData = credentials;
      return Api().post('/index.php', formData )
        .then(resp => {
          resolve(resp);
        })
        .catch(err => {
          reject(err);
        });
    });


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
