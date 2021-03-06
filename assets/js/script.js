window.addEventListener('load', () => {

    if (document.querySelector('.hamburger-menu')) {
        document
            .querySelector('.hamburger-menu')
            .addEventListener('click', () => hamburgerMenu())

        function hamburgerMenu() {
            const sidebar = document.querySelector('.sidebar');
            const gridContainer = document.querySelector('.grid-container');
            gridContainer.classList.toggle('grid-container-toggle-menu');
            sidebar.classList.toggle('sidebar-toggle-menu');
        }
    }

    if (document.querySelector('.grid-container')) {
        hakAksesMenu()

        async function hakAksesMenu() {
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        proses: 'hak_akses_menu',
                    }),
                })
                .then((response) => response.json())
                .then((response) => response.akses.split('-'))
                .then((response) => {
                    response.forEach((item) => {
                        document.querySelector(`.${item}`).style.display = 'block'
                    })
                })
        }
    }

    /* -------------- Halaman Login ------------------ */

    if (document.querySelector('.container-login')) {
        document.querySelector('#login-form').addEventListener('submit', (e) => {
            e.preventDefault()
            login()
        })

        async function login() {
            const user = document.querySelector('#username').value;
            const pass = document.querySelector('#password').value;
            const sendData = {
                proses: 'login',
                username: user,
                password: pass,
            }
            await fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(sendData),
                })
                .then((response) => response.json())
                .then((response) => {
                    if (response.pesan === 'error') {
                        document.querySelector('.pesan-login').innerHTML = 'Username/password salah!!';
                        document.querySelector('.pesan-login').style.color = 'red'
                        setTimeout(() => {
                            document.querySelector('.pesan-login').style.display = 'none'
                        }, 2000)
                        document.querySelector('.pesan-login').style.display = 'block'
                        document.querySelector('#login-form').reset()
                    } else {
                        window.location.replace('index.php')
                    }
                })
        }
    }

    /* -------------- Halaman User ------------------ */

    if (document.querySelector('.halaman-user')) {
        // menu tab
        document.querySelector('.menu-data-user').addEventListener('click', () => {
            document.querySelector('.content-data-user').style.display = 'block';
            document.querySelector('.content-usergrup').style.display = 'none';
            document.querySelector('.content-log-user').style.display = 'none';
        });
        document.querySelector('.menu-usergrup').addEventListener('click', () => {
            document.querySelector('.content-data-user').style.display = 'none';
            document.querySelector('.content-usergrup').style.display = 'block';
            document.querySelector('.content-log-user').style.display = 'none';
        });
        document.querySelector('.menu-log-user').addEventListener('click', () => {
            document.querySelector('.content-data-user').style.display = 'none';
            document.querySelector('.content-usergrup').style.display = 'none';
            document.querySelector('.content-log-user').style.display = 'block';
        });

        document.querySelector('.button-form-tambah-user').addEventListener('click', () => buttonFormTambahUser());

        function buttonFormTambahUser() {
            const addUserForm = document.querySelector('.form-tambah-user');
            addUserForm.classList.toggle('form-tambah-user-toggle');
        }

        document.querySelector('#jumlah-tampil-data-user').addEventListener('change', () => showDataUser());
        document.querySelector('.search-data-user').addEventListener('keyup', (e) => {
            const sendData = e.target.value;
            showDataUser(sendData);
        });

        function paginationPrev() {
            document.querySelector('.prev').addEventListener('click', () => {
                let prev = document.querySelector('.prev').getAttribute('value');
                showDataUser(null, prev, prev);
            });
        }

        function paginationNext() {
            document.querySelector('.next').addEventListener('click', () => {
                let next = document.querySelector('.next').getAttribute('value');
                showDataUser(null, next, next);
            });
        }

        function pagination() {
            let tampilPagination = document.querySelectorAll('.tampil-pagination');
            for (let i = 0; i < tampilPagination.length; i++) {
                tampilPagination[i].addEventListener('click', () => {
                    let op = tampilPagination[i].value;
                    showDataUser(null, op, op);
                });
            }
        }

        showDataUser();
        paginationPrev();
        paginationNext();

        function showDataUser(where = null, offSet = null, pageNumber = null) {
            const jumlahTampilDataUser = document.querySelector('#jumlah-tampil-data-user').value;
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proses: 'data_user_baru',
                        kondisi: where,
                        offset: offSet,
                        page: pageNumber,
                        limit: jumlahTampilDataUser,
                    }),
                })
                .then((res) => res.json())
                .then((res) => {
                    let data = '';
                    let paginationData = '';

                    if (typeof res.pesan === 'undefined') {
                        let status = ''
                        let nomor = 0;

                        if (res.page == 0) {
                            nomor = 0;
                        } else {
                            nomor = res.page;
                        }

                        res.data.forEach((value) => {
                            nomor++
                            data += `
                            <tr>
                                <td>${nomor}</td>
                                <td>${value['username']}</td>
                                <td>${value['password']}</td>
                                <td>
                                <select class="input-small" name="${value['iduser']}" id="usergrup">`;

                            let idusergrup = value['idusergrup'];
                            res.usergrup.forEach((value) => {
                                if (idusergrup === value['idusergrup']) {
                                    selected = 'selected'
                                } else {
                                    selected = ''
                                }

                                data += `<option value="${value['idusergrup']}" ${selected}>${value['usergrup']}</option>`;
                            })
                            data += `
                                </select>
                                </td>
                                <td><select class="input-small" name="${value['iduser']}" class="status-user">`;

                            if (value['status'] === 'Active') {
                                status = `<option value="Active" Selected>Active</option>
                                            <option value="Inactive">Inactive</option>`
                            } else {
                                status = `<option value="Active">Active</option>
                                            <option value="Inactive"  Selected>Inactive</option>`
                            }

                            data += `${status}</select></td>
                                <td><button class="button-edit-user button-orange button-small" value="${value['iduser']}">Update</button></td>
                            </tr>`;
                        });

                        let totalHalaman = Math.ceil(res.jumlah_data / jumlahTampilDataUser);
                        let prev = 0;

                        if (parseInt(res.page) == 0) {
                            document.querySelector('.prev').style.display = 'none';
                        } else {
                            prev = res.page - jumlahTampilDataUser;
                            document.querySelector('.prev').setAttribute('value', prev);
                            document.querySelector('.prev').style.display = 'block';
                        }

                        let nomorPagination = 0;

                        for (let i = 0; i < totalHalaman; i++) {
                            nomorPagination++;
                            if (i === 10) break;
                            hasil = i * jumlahTampilDataUser;
                            paginationData += `<button type=button class="tampil-pagination button-small button-normal" value="${hasil}">${nomorPagination}</button>`;
                        }

                        let next = 0;

                        if (res.page == res.jumlah_data) {
                            document.querySelector('.next').style.display = 'none';
                        } else {
                            page = parseInt(res.page);
                            jumlahTampil = parseInt(jumlahTampilDataUser);
                            next = page + jumlahTampil;
                            nextValue = parseInt(next);
                            document.querySelector('.next').setAttribute('value', nextValue);
                            document.querySelector('.next').style.display = 'block';
                        }

                        document.querySelector('.pagination-number').innerHTML = paginationData;
                    } else {
                        data = `<tr><td colspan="6" align="center">Data tidak ditemukan!</td></tr>`;
                    }
                    document.querySelector('.data-user').innerHTML = data;
                })
                .then(() => {
                    editUser();
                    updateUsergrupUser();
                    updateStatusUser();
                    pagination();
                });

        }

        // update user
        function editUser() {
            const buttonEditUser = document.querySelectorAll('.button-edit-user');
            for (let i = 0; i < buttonEditUser.length; i++) {
                buttonEditUser[i].addEventListener('click', (e) => {
                    document.querySelector('.update-user').style.display = 'block'
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                proses: 'update_user',
                                iduser: buttonEditUser[i].value,
                            }),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            let data = `
                            <form class="form-update-user">
                            <label class="label-ve">Username</label>
                            <input class="input-small" type="text" name="username" id="username" value="${response.username}" required>
                            <label class="label-ve">Password</label>
                            <input class="input-small" type="text" name="password" id="password" value="${response.password}" required>
                            <button class="button-update-user button-small button-orange" type="submit">Update</button>
                            </form>
                        `
                            document.querySelector('.update-user').innerHTML = data
                        })
                        .then(() => {
                            document.querySelector('.form-update-user').addEventListener('submit', (e) => {
                                e.preventDefault()
                                const userName = document.querySelector('#username').value
                                const passWord = document.querySelector('#password').value
                                fetch('core/proses.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            proses: 'simpan_update_user',
                                            iduser: buttonEditUser[i].value,
                                            username: userName,
                                            password: passWord,
                                        }),
                                    })
                                    .then((response) => response.json())
                                    .then((response) => {
                                        let result = Object.keys(response).toString()
                                        if (result === 'sukses') {
                                            document.querySelector('.update-user').style.display =
                                                'none'
                                            document.querySelector('.pesan').innerHTML =
                                                response.sukses
                                            document.querySelector('.pesan').style.color = 'green'
                                            document.querySelector('.pesan').style.display = 'block'
                                            setTimeout(() => {
                                                document.querySelector('.pesan').style.display =
                                                    'none'
                                            }, 1000)
                                            showDataUser();
                                            showDataLogUser();
                                        } else {
                                            document.querySelector('.pesan').innerHTML =
                                                response.error
                                            document.querySelector('.pesan').style.color = 'red'
                                            document.querySelector('.pesan').style.display = 'block'
                                            setTimeout(() => {
                                                document.querySelector('.pesan').style.display =
                                                    'none'
                                            }, 1000)
                                            showDataUser();
                                        }
                                    })
                            })
                        })
                })
            }
        }
        // delete user tidak digunakan
        // diganti dengan active dan inactive
        function deleteUser() {
            const buttonDeleteUser = document.querySelectorAll('.button-delete-user')
            for (let i = 0; i < buttonDeleteUser.length; i++) {
                buttonDeleteUser[i].addEventListener('click', async () => {
                    let id = buttonDeleteUser[i].value
                    let sendData = {
                        proses: 'delete_user',
                        iduser: id,
                    }
                    let data = await fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                //'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: JSON.stringify(sendData),
                        })
                        .then((response) => response.json())
                        .then(() => showDataUser())
                })
            }
        }
        // update usergrup user (select box)
        function updateUsergrupUser() {
            let up = document.querySelectorAll('#usergrup')
            for (let i = 0; i < up.length; i++) {
                up[i].addEventListener('change', (e) => {
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                proses: 'update_user_usergrup',
                                iduser: e.target.getAttribute('name'),
                                idusergrup: e.target.value,
                            }),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            let result = Object.keys(response).toString()
                            if (result === 'sukses') {
                                document.querySelector('.update-user').style.display = 'none'
                                document.querySelector('.pesan').innerHTML = response.sukses
                                document.querySelector('.pesan').style.color = 'green'
                                document.querySelector('.pesan').style.display = 'block'
                                setTimeout(() => {
                                    document.querySelector('.pesan').style.display = 'none'
                                }, 1000)
                                showDataUser();
                                showDataLogUser();
                            } else {
                                document.querySelector('.pesan').innerHTML = response.error
                                document.querySelector('.pesan').style.color = 'red'
                                document.querySelector('.pesan').style.display = 'block'
                                setTimeout(() => {
                                    document.querySelector('.pesan').style.display = 'none'
                                }, 1000)
                                showDataUser()
                            }
                        })
                })
            }
        }
        // submit tambah user
        const submitSimpanUser = document.querySelector('.form-tambah-user')
        submitSimpanUser.addEventListener('submit', (e) => {
            e.preventDefault()
            tambahUser()
        })

        function tambahUser() {
            const formData = document.querySelector('.form-tambah-user')
            const dataForm = new FormData(formData)
            dataForm.append('proses', 'tambah_user')
            let data = {}
            dataForm.forEach((value, index) => {
                data[index] = value
            })
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((response) => {
                    let result = Object.keys(response).toString()
                    if (result === 'sukses') {
                        document.querySelector('.update-user').style.display = 'none'
                        document.querySelector('.pesan-tambah-user').innerHTML =
                            response.sukses
                        document.querySelector('.pesan-tambah-user').style.color = 'green'
                        document.querySelector('.pesan-tambah-user').style.display = 'block'
                        setTimeout(() => {
                            document.querySelector('.pesan-tambah-user').style.display =
                                'none'
                        }, 1000)
                        document.querySelector('.form-tambah-user').reset()
                        showDataUser();
                        showDataLogUser();
                    } else {
                        document.querySelector('.pesan-tambah-user').innerHTML =
                            response.error
                        document.querySelector('.pesan-tambah-user').style.color = 'red'
                        document.querySelector('.pesan-tambah-user').style.display = 'block'
                        setTimeout(() => {
                            document.querySelector('.pesan-tambah-user').style.display =
                                'none'
                        }, 1000)
                        showDataUser()
                    }
                })
        }
        // update status user (select box)
        function updateStatusUser() {
            const statusUser = document.querySelectorAll('.status-user')
            for (let i = 0; i < statusUser.length; i++) {
                statusUser[i].addEventListener('change', (e) => {
                    const iduser = e.target.getAttribute('name')
                    const statusValue = e.target.value
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                proses: 'update_status_user',
                                iduser: iduser,
                                status: statusValue,
                            }),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            alert(response.pesan);
                            showDataLogUser();
                        })
                })
            }
        }

        /*----------------- USERGRUP -----------------*/
        // Menampilkan data usergrup

        dataUsergrup();
        tambahUsergrup();
        document.querySelector('#form-update-usergrup').addEventListener('submit', (e) => {
            e.preventDefault();
            simpanUpdateUsergrup();
        });


        function dataUsergrup() {
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        proses_usergrup: 'data_usergrup'
                    }),
                })
                .then((response) => response.json())
                .then((response) => {
                    let data = '';
                    let nomor = 0;
                    for (let i = 0; i < response.length; i++) {
                        nomor += 1
                        data += `
                            <tr>
                                <td>${nomor}</td>
                                <td>${response[i].usergrup}</td>
                                <td>${response[i].akses}</td>
                                <td width="60px"><button class="button-update-usergrup button-orange button-small" value="${response[i].idusergrup}">Update</button></td>
                            </tr>
                        `;
                    }
                    document.querySelector('.data-usergrup').innerHTML = data;
                })
                .then(() => {
                    updateUsergrup();
                });
        }

        function tambahUsergrup() {
            document.querySelector('#form-tambah-usergrup').addEventListener('submit', (e) => {
                e.preventDefault();
                const pesan = document.querySelector('.pesan-usergrup');
                pesan.style.display = 'block';
                const formTambahUsergrup = document.querySelector('#form-tambah-usergrup');
                const formData = new FormData(formTambahUsergrup);
                formData.append('proses_usergrup', 'tambah_usergrup');

                let aksesValue = [];
                const akses = document.querySelectorAll('.akses');
                for (let i = 0; i < akses.length; i++) {
                    if (akses[i].checked === true) {
                        aksesValue.push(akses[i].value);
                    }
                }

                formData.set('akses', aksesValue);

                let data = {};
                formData.forEach((value, index) => {
                    data[index] = value;
                });

                fetch('core/proses.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.hasOwnProperty('error')) {
                            const pesan = document.querySelector('.pesan-usergrup');
                            pesan.style.display = 'block';
                            pesan.style.color = 'red';
                            pesan.innerHTML = 'Error';
                            setTimeout(() => pesan.style.display = 'none', 2000);
                            throw new Error(response.error);
                        } else {
                            const pesan = document.querySelector('.pesan-usergrup');
                            pesan.style.display = 'block';
                            pesan.style.color = 'green';
                            pesan.innerHTML = response.sukses;
                            document.querySelector('#form-tambah-usergrup').reset();
                            dataUsergrup();
                            setTimeout(() => pesan.style.display = 'none', 2000);
                        }
                    })
                    .catch(error => console.log(error));
            });
        }

        function updateUsergrup() {
            const buttonUpdate = document.querySelectorAll('.button-update-usergrup');
            for (let i = 0; i < buttonUpdate.length; i++) {
                buttonUpdate[i].addEventListener('click', () => {
                    document.querySelector('#form-update-usergrup').style.display = 'block';
                    document.querySelector('#form-tambah-usergrup').style.display = 'none';
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                proses_usergrup: 'update_usergrup',
                                idusergrup: buttonUpdate[i].value
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.hasOwnProperty('error')) {
                                throw new Error(response.error);
                            } else {
                                document.querySelector('#input-update-usergrup').value = response.usergrup;
                                let akses = response.akses.split('-');
                                const checkAkses = document.querySelectorAll('.akses-usergrup');
                                for (let i = 0; i < checkAkses.length; i++) {
                                    checkAkses[i].checked = false;
                                    if (akses.includes(checkAkses[i].value)) {
                                        checkAkses[i].checked = true;
                                    }
                                }
                                document.querySelector('#simpan-idusergrup').setAttribute('value', response.idusergrup);
                            }
                        })
                        .catch(error => console.log(error));
                });
            }
        }

        function simpanUpdateUsergrup() {
            const formUpdateUsergrup = document.querySelector('#form-update-usergrup');
            const formData = new FormData(formUpdateUsergrup);
            formData.append('proses_usergrup', 'simpan_update_usergrup');

            let aksesValue = [];
            const akses = document.querySelectorAll('.akses-usergrup');
            akses.forEach((value, index) => {
                if (akses[index].checked === true) {
                    aksesValue.push(akses[index].value);
                }
            });

            formData.set('akses', aksesValue);

            let data = {};
            formData.forEach((value, index) => {
                data[index] = value;
            });

            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('error')) {
                        const pesan = document.querySelector('.pesan-usergrup');
                        pesan.style.display = 'block';
                        pesan.style.color = 'red';
                        pesan.innerHTML = 'Error';
                        setTimeout(() => pesan.style.display = 'none', 2000);
                        throw new Error(response.error);
                    } else {
                        document.querySelector('#form-update-usergrup').style.display = 'none';
                        document.querySelector('#form-tambah-usergrup').style.display = 'block';
                        const pesan = document.querySelector('.pesan-usergrup');
                        pesan.style.display = 'block';
                        pesan.style.color = 'green';
                        pesan.innerHTML = response.sukses;
                        document.querySelector('#form-tambah-usergrup').reset();
                        dataUsergrup();
                        setTimeout(() => pesan.style.display = 'none', 2000);
                    }
                })
                .catch(error => console.log(error));
        }

        /*----------------- LOG USER -----------------*/

        showDataLogUser();

        document.querySelector('#search-log-user').addEventListener('change', (e) => {
            const month = e.target.value;
            showDataLogUser(month);
        });

        function showDataLogUser(where = null) {
            if (where === null) {
                where = searchLogUser();
            }
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proses_log: 'user',
                        kondisi: where
                    })
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('error')) {
                        data = `
                            <tr>
                                <td colspan='4' align='center'>Data Error</td>
                            </tr>
                        `;
                    } else {
                        data = '';
                        if (response.hasOwnProperty('kosong')) {
                            data = `
                            <tr>
                                <td colspan='4' align='center'>${response.kosong}</td>
                            </tr>
                        `;
                        } else {
                            let index = 0;
                            response.forEach(value => {
                                data += `
                                    <tr>
                                        <td align='center'>${response[index].username}</td>
                                        <td align='center'>${response[index].status}</td>
                                        <td align='center'>${response[index].event}</td>
                                        <td align='center'>${response[index].tanggal}</td>
                                    </tr>
                                `;
                                index++;
                            });
                        }
                    }
                    document.querySelector('.table-content-log-user').innerHTML = data;
                })
                .catch(error => console.log(error));
        }

        function searchLogUser() {
            const date = new Date();
            const searchLogUserValue = document.querySelectorAll('.search-log-user-value');
            for (let index = 0; index < searchLogUserValue.length; index++) {
                if (searchLogUserValue[index].value == date.getMonth()) {
                    let monthNow = 1 + date.getMonth();
                    document.querySelector('#search-log-user').value = monthNow;
                    return monthNow;
                }
            }
        }

    }

    /* -------------- Halaman Gudang ------------------ */

    if (document.querySelector('.halaman-gudang')) {

        showDataGudang();

        document.querySelector('.button-form-tambah-gudang').addEventListener('click', () => {
            const button = document.querySelector('.form-tambah-gudang');
            button.classList.toggle('form-toggle');
        });
        document.querySelector('#form-tambah-gudang').addEventListener('submit', (e) => {
            e.preventDefault();
            const formTambahGudang = document.querySelector('#form-tambah-gudang');
            const alamatGudang = document.querySelector('#alamat-gudang');
            const formData = new FormData(formTambahGudang);
            formData.append('alamat', alamatGudang.value);
            formData.append('proses_gudang', 'tambah_gudang');
            let data = {};
            formData.forEach((value, index) => {
                data[index] = value;
            });
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('error')) {
                        alert(response.error);
                        throw new Error(response.error);
                    } else {
                        alert(response.sukses);
                        formTambahGudang.reset();
                        showDataGudang();
                    }
                })
                .catch(error => console.log(error));
        });
        document.querySelector('#form-update-gudang').addEventListener('submit', (e) => {
            e.preventDefault();
            const formUpdateGudang = document.querySelector('#form-update-gudang');
            const alamatGudang = document.querySelector('#alamat-gudang');
            const updateIdGudang = document.querySelector('#update-idgudang');
            const formData = new FormData(formUpdateGudang);
            formData.append('proses_gudang', 'simpan_update_gudang');
            formData.append('idgudang', updateIdGudang.value);
            let data = {};
            formData.forEach((value, index) => {
                data[index] = value;
            });
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('error')) {
                        throw new Error(response.error);
                    } else {
                        alert(response.sukses);
                        document.querySelector('#form-update-gudang').style.display = 'none';
                        showDataGudang();
                    }
                })
                .catch(error => console.log(error));
        });

        function showDataGudang() {
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proses_gudang: 'data_gudang'
                    })
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('error')) {
                        throw new Error(response.error);
                    } else {
                        let data = '';
                        if (response.hasOwnProperty('kosong')) {
                            data = `
                                <tr>
                                    <td colspan="6">${response.kosong}</td>
                                </tr>
                            `;
                        } else {
                            let nomor = 1;
                            for (let i = 0; i < response.length; i++) {
                                data += `
                                    <tr>
                                        <td align="center">${nomor}</td>
                                        <td>${response[i].idgudang}</td>
                                        <td>${response[i].nama_gudang}</td>
                                        <td>${response[i].alamat}</td>
                                        <td align="center"><button class="button-update-gudang button-small button-orange" id="${response[i].idgudang}">Update</button> <button class="button-delete-gudang button-small button-red" id="${response[i].idgudang}">Delete</button></td>
                                    </tr>
                                `;
                                nomor++;
                            }
                        }
                        document.querySelector('.table-data-gudang').innerHTML = data;
                    }
                })
                .then(() => {
                    updateGudang();
                    deleteGudang();
                })
                .catch(error => console.log(response.error));
        }

        function deleteGudang() {
            let buttonDeleteGudang = document.querySelectorAll('.button-delete-gudang');
            for (let i = 0; i < buttonDeleteGudang.length; i++) {
                buttonDeleteGudang[i].addEventListener('click', () => {
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                proses_gudang: 'delete_gudang',
                                id: buttonDeleteGudang[i].getAttribute('id')
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.hasOwnProperty('error')) {
                                throw new Error(response.error);
                            } else {
                                alert(response.sukses);
                                showDataGudang();
                            }
                        })
                        .catch(error => console.log(error));
                })
            }
        }

        function updateGudang() {
            const buttonUpdateGudang = document.querySelectorAll('.button-update-gudang');
            for (let i = 0; i < buttonUpdateGudang.length; i++) {
                buttonUpdateGudang[i].addEventListener('click', () => {
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                proses_gudang: 'update_gudang',
                                idgudang: buttonUpdateGudang[i].getAttribute('id')
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            document.querySelector('#update-idgudang').value = response.idgudang;
                            document.querySelector('#update-nama-gudang').value = response.nama_gudang;
                            document.querySelector('#update-alamat-gudang').value = response.alamat;
                        })
                    document.querySelector('.form-update-gudang').style.display = 'block';
                });
            }
        }
    }

    /*
    ############################################################################
                                    Halaman Produk
    ############################################################################
    */

    if (document.querySelector('.halaman-produk')) {

        document.querySelector('.menu-daftar-produk').addEventListener('click', () => {
            document.querySelector('.content-daftar-produk').style.display = 'block';
            document.querySelector('.content-tambah-produk').style.display = 'none';
            document.querySelector('.content-update-produk').style.display = 'none';
        });
        document.querySelector('.menu-tambah-produk').addEventListener('click', () => {
            document.querySelector('.content-daftar-produk').style.display = 'none';
            document.querySelector('.content-tambah-produk').style.display = 'block';
            document.querySelector('.content-update-produk').style.display = 'none';
        });
        document.querySelector('.back-daftar-produk').addEventListener('click', () => {
            document.querySelector('.content-daftar-produk').style.display = 'block';
            document.querySelector('.content-update-produk').style.display = 'none';
        });

        // menampilkan data produk
        showDataProduk();
        // tambah produk
        document.querySelector('#form-tambah-produk').addEventListener('submit', (e) => {
            e.preventDefault();
            addProduk();
        });


        function showDataProduk() {
            fetch('core/proses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        proses_produk: 'show_data_produk'
                    })
                })
                .then(res => res.json())
                .then(res => {
                    let data = '';
                    if (res.hasOwnProperty('kosong')) {
                        data = `
                            <tr>
                                <td colspan="7">${res.kosong}</td>
                            </tr>
                        `;
                    } else {
                        let nomor = 1;
                        for (let i = 0; i < res.length; i++) {
                            data += `
                            <tr>
                                <td align="center">${i+1}</td>
                                <td align="center">${res[i].kode_produk}</td>
                                <td>${res[i].produk}</td>
                                <td align="center">${res[i].harga}</td>
                                <td align="center">${res[i].stok}</td>
                                <td align="center"><img class="img-produk" src="assets/img/${res[i].gambar}"></td>
                                <td align="center"><button id="${res[i].kode_produk}" class="button-orange button-small id-update">Update</button> <button id="${res[i].kode_produk}" class="button-red button-small id-delete">Delete</button></td>
                            </tr>
                        `;
                        }
                    }

                    document.querySelector('.table-produk').innerHTML = data;
                })
                .then(() => {
                    update();
                    // delete produk
                    deleteProduk();
                })
                .catch(error => console.log(error));
        }

        function addProduk() {
            const tambahProduk = document.querySelector('#form-tambah-produk');
            // const fileFoto = document.querySelector('#file-foto');
            let formdata = new FormData(tambahProduk);
            formdata.append('proses_produk', 'add_produk');
            fetch('core/proses_produk.php', {
                    method: 'POST',
                    body: formdata
                })
                .then(res => res.json())
                .then(res => {
                    if (res.hasOwnProperty('duplikasi_kode_produk')) {
                        alert(res.duplikasi_kode_produk);
                    } else if (res.hasOwnProperty('duplikasi_nama_produk')) {
                        alert(res.duplikasi_nama_produk);
                    } else if (res.hasOwnProperty('error')) {
                        throw new Error(res.error);
                    } else if (res.hasOwnProperty('gagal')) {
                        alert(res.gagal);
                    } else {
                        alert(res.sukses);
                        showDataProduk();
                        tambahProduk.reset();
                    }
                })
                .catch(error => console.log(error));
        }

        function update() {
            const idUpdate = document.querySelectorAll('.id-update');
            for (let index = 0; index < idUpdate.length; index++) {
                idUpdate[index].addEventListener('click', () => {
                    document.querySelector('.content-update-produk').style.display = 'block';
                    document.querySelector('.content-daftar-produk').style.display = 'none';
                    const id = idUpdate[index].getAttribute('id');
                    fetch('core/proses.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                proses_produk: 'update_produk',
                                idproduk: id
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            document.querySelector('#up-kode-produk').value = response.kode_produk;
                            document.querySelector('#update-kode-produk').value = response.kode_produk;
                            document.querySelector('#update-produk').value = response.produk;
                            document.querySelector('#update-harga').value = response.harga;
                            document.querySelector('#update-stok').value = response.stok;
                            document.querySelector('#update-file-foto').src = 'assets/img/' + response.gambar;
                        })
                        .catch(error => console.log(error));
                });
            }
        }

        document.querySelector('#form-update-produk').addEventListener('submit', (e) => {
            e.preventDefault();
            edit();
        });

        function edit() {
            const updateProduk = document.querySelector('#form-update-produk');
            // const fileFoto = document.querySelector('#file-foto');
            let formdata = new FormData(updateProduk);
            formdata.append('proses_produk', 'edit_produk');
            fetch('core/proses_produk.php', {
                    method: 'POST',
                    body: formdata
                })
                .then(response => response.json())
                .then(response => {
                    if (response.hasOwnProperty('gagal')) {
                        throw new Error(response.error);
                    } else if (response.hasOwnProperty('duplikasi_nama_produk')) {
                        alert('Error : ' + response.duplikasi_nama_produk);
                    } else {
                        alert(response.sukses);
                        showDataProduk();
                    }
                })
                .catch(error => console.log(error));
        }

        function deleteProduk() {
            const id = document.querySelectorAll('.id-delete');
            for (let index = 0; index < id.length; index++) {
                id[index].addEventListener('click', () => {
                    const data = {
                        proses_produk: 'delete_produk',
                        id: id[index].getAttribute('id')
                    }
                    fetch('core/proses.php', {
                            method: 'POST',
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.hasOwnProperty('error')) {
                                throw new Error(response.error);
                            } else {
                                alert(response.sukses);
                                showDataProduk();
                            }
                        })
                        .catch(error => console.log(error))
                });
            }
        }

    }

    /*
    ############################################################################
                                    Halaman Pelanggan
    ############################################################################
    */

    if (document.querySelector('.halaman-pelanggan')) {

        $('#table_id').DataTable({
            "ajax": {
                "url": "core/data-pelanggan.php",
                "type": "POST",
                "datatype": "json"
            },
            columns: [{
                    data: 'nama'
                },
                {
                    data: 'no_telp'
                }
            ]
        });


    }

    /*
    ############################################################################
                                    Halaman Laporan
    ############################################################################
    */

    if (document.querySelector('.halaman-laporan')) {

        $('#table-laporan').DataTable({
            "ajax": {
                "url": "core/data-laporan.php",
                "type": "POST",
                "datatype": "json"
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'customer'
                },
                {
                    data: 'no_nota'
                },
                {
                    data: 'kasir'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'total'
                },
                {
                    data: 'keterangan'
                }
            ]
        });


    }


    /*
    ############################################################################
                                    Halaman Penjualan
    ############################################################################
    */

    if (document.querySelector('.halaman-penjualan')) {

        const cariPelanggan = document.querySelector('.cari-pelanggan');
        cariPelanggan.addEventListener('input', () => {
            $('.cari-pelanggan').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: 'core/pelanggan.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    document.querySelector('.cari-pelanggan').value = "";
                    document.querySelector('#nama-customer').value = ui.item.label;
                    document.querySelector('#customer-id').value = ui.item.value;
                    fetch('core/proses.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                transaksi: 'get_no_nota'
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            let date = new Date();
                            let year = date.getFullYear();
                            let arrMonth = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                            let month = date.getMonth();
                            let day = date.getDate();
                            let inv = 'INV' + day + '' + arrMonth[month] + '' + year + '' + response;
                            document.querySelector('#no-nota').value = inv;
                            document.querySelector('#no-nota-form').value = inv;
                        });
                    return false;
                }
            });
        });

        document.querySelector('.button-tambah-customer').addEventListener('click', () => {
            // document.querySelector('.add-customer').style.display = "block";
            let addCustomer = document.querySelector('.add-customer');
            addCustomer.classList.toggle('add-customer-toggle');
        });

        document.querySelector('.button-simpan-customer').addEventListener('click', (e) => {
            e.preventDefault();
            // document.querySelector('.add-customer').style.display = "none";
        });

        document.querySelector('#create-element-produk').addEventListener('click', () => {
            createElementProduk();
        });

        document.querySelector('.form-bottom').addEventListener('click', (e) => {
            if (e.target.getAttribute('class') === 'button-red delete-input') {
                e.target.parentElement.remove();
            }
            if (e.target.getAttribute('class') === 't-produk') {
                let parent = e.target.parentElement;
                let produk = parent.children[0].getAttribute('class');
                let harga = parent.children[1].getAttribute('class');
                $('.' + produk).autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: 'core/data_produk.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                search: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    select: function (event, ui) {
                        parent.children[0].value = ui.item.label;
                        parent.children[1].value = ui.item.value;
                        parent.children[4].value = ui.item.kode_produk;
                        parent.children[5].value = ui.item.value;
                        return false;
                    }
                });


            }
            if (e.target.getAttribute('name') === 'qty[]') {
                let parent = e.target.parentElement;
                parent.children[2].addEventListener('input', () => {
                    let harga = parent.children[1].value;
                    let subTotal = harga * parent.children[2].value;
                    parent.children[3].value = subTotal;
                    parent.children[6].value = subTotal;
                    let jumlahProduk = document.querySelectorAll('.t-qty');
                    let totalItem = 0;
                    for (let i = 0; i < jumlahProduk.length; i++) {
                        totalItem += parseInt(jumlahProduk[i].value);
                    }
                    let JumlahItem = document.querySelectorAll('.jumlah-item');
                    for (let i = 0; i < JumlahItem.length; i++) {
                        JumlahItem[i].value = totalItem;
                    }
                    let jumlahBayar = document.querySelectorAll('.t-sub-total');
                    let totalBayar = 0;
                    for (let i = 0; i < jumlahBayar.length; i++) {
                        totalBayar += parseInt(jumlahBayar[i].value);
                    }
                    let TotalBayar = document.querySelectorAll('.total-bayar');
                    for (let i = 0; i < TotalBayar.length; i++) {
                        TotalBayar[i].value = totalBayar;
                    }
                });
            }
        });

        function createElementProduk() {
            let content = document.createElement('div');
            content.classList.add('input-transaksi');
            content.innerHTML = `
            <input class="t-produk" type="text">
            <input class="t-harga" type="text" placeholder="Harga" disabled>
            <input class="t-qty" type="number" name="qty[]" placeholder="Qty">
            <input class="t-sub-total" type="text" placeholder="Sub Total" disabled>
            <input class="kode-produk" type="text" name="produk[]" hidden>
            <input type="text" name="harga[]" hidden>
            <input type="text" name="sub_total[]" hidden>
                <button type="button" class="button-red delete-input">-</button>
            `;
            const endTransaction = document.querySelector('.end-transaction');
            const parent = document.querySelector('.form-bottom');
            parent.insertBefore(content, endTransaction);
        }

        document.querySelector('#bayar').addEventListener('input', () => {
            let totalBayar = document.querySelector('.total-bayar').value;
            let bayar = document.querySelector('#bayar').value;
            let kembali = bayar - totalBayar;
            document.querySelector('#kembali').value = kembali;
        });

        // add customer
        document.querySelector('#submit-add-customer').addEventListener('click', (e) => {
            e.preventDefault();
            const addCustomer = document.querySelector('#add-customer');
            let data = new FormData(addCustomer);
            data.append('submit', 'add_customer');
            fetch('core/add_customer.php', {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(response => {
                    // alert(response);
                    if (response.hasOwnProperty('duplikat')) {
                        alert(response.duplikat);
                        // document.querySelector('#pesan-pelanggan').html = response.duplikat;
                        // document.querySelector('#pesan-pelanggan').style.color = 'red';
                    }
                    if (response.hasOwnProperty('sukses')) {
                        alert(response.sukses);
                        document.querySelector('#add-customer').reset();
                        // document.querySelector('#pesan-pelanggan').html = response.sukses;
                        // document.querySelector('#pesan-pelanggan').style.color = 'green';
                    }
                })
                .catch(error => console.log(error));
        });


    }



})