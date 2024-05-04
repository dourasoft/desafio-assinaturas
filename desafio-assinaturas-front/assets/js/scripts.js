function spin(on = false) {
    if (on) {
        $(".spin_load").css("z-index", "9999999999").css("display", "flex").fadeIn(200);
        return;
    }
    $(".spin_load").fadeOut();
    return;
}

function formatDate(timestamp, format) {
    const data = new Date(timestamp);

    return data.toLocaleDateString(format);
}

function formatarMoedaBRL(valor) {
    valor = parseFloat(valor);

    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

async function message(text) {
    if (text == "") {
        Swal.fire({
            text: 'API error',
            icon: 'error',
        });
    } else {
        Swal.fire({
            text: text,
            icon: 'warning',
        });
    }

    return false;
}

async function html(path) {
    const response = await fetch(path);//ajax
    const data = await response.text();
    const object = await data;

    return await object;
}

async function bridge(package) {
    const url = '/app/bridge.php';

    const options = {
        method: 'POST',
        body: JSON.stringify(package)
    };

    try {
        const response = await fetch(url, options);//ajax
        const data = await response.json();
        const object = await data;

        //Retorno das chamadas dos endpoints
        //console.log(object);

        return await object;
    } catch (error) {
        spin(false);
        throw message(`A ponte está quebrada e, portanto, nenhum dado é transmitido: ${error}`);
    }
}

/**
 * LOGIN
 * @param {*} order 
 * @returns 
 */
function validateLogin(order = null) {
    const email = $("#email").val();
    const password = $("#password").val();

    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const regexPass = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[\W_]).{8,}$/;

    const box_message = $(".box_message");
    const message_validation = $(".message_validation");

    if (email.trim() === '' || password.trim() === '') {
        message_validation.html('Ops! Existem campos não preenchidos.');
        box_message.removeClass("hidden");

        return false;
    }

    if (!regexEmail.test(email)) {
        message_validation.html('Ops! Formato de email inválido.');
        box_message.removeClass("hidden");

        return false;
    }

    if (!regexPass.test(password) || password.length < 8) {
        message_validation.html('Ops! A senha deve ter pelo menos 8 caracteres e conter letras maiúsculas, números e caracteres especiais.');
        box_message.removeClass("hidden");

        return false;
    }

    //api
    if (order && order.status != 200) {
        message_validation.html(`Ops! ${order.response.error}`);
        box_message.removeClass("hidden");

        return false;
    }

    message_validation.html('');
    return true;
}

async function login() {
    spin(true);

    const email = $("#email").val();
    const password = $("#password").val();

    if (!validateLogin()) {
        spin(false);
        return;
    }

    try {
        const package = {
            controller: "LoginUser",
            data: {
                email: email,
                password: password
            }
        };

        const order = await bridge(package);
        console.log(order);

        if (order) {
            if (!validateLogin(order)) {
                spin(false);
                return;
            }

            window.location.href = '/src/index.php';
            return;
        }

    } catch (error) {
        spin(false);
        throw message('login', `EXCEPTION function login: ${error}`);
    }
}

async function logout() {
    try {
        const package = {
            controller: "LogoutUser"
        };

        Swal.fire({
            title: 'Deslogar do Sistema?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then(async (result) => {
            if (result.isConfirmed) {
                spin(true);
                const order = await bridge(package);

                if (order) {
                    spin(false);
                    window.location.href = '/index.php';
                    return;
                }
            }
        });

    } catch (error) {
        spin(false);
        throw message('login', `EXCEPTION function logout: ${error}`);
    }
}

/**
 * Listagem
 * @param {*} controller 
 * @returns 
 */
async function index(controller) {
    spin(true);

    try {
        const package = {
            controller: controller
        };

        const order = await bridge(package);

        if (order.status != 200) {
            spin(false);
            return false;
        }

        if (order) {
            spin(false);

            if (controller == "IndexCadastro") {
                await populaTabelaCadastros(order, controller);
            }

            if (controller == "IndexAssinatura") {
                await populaTabelaAssinaturas(order, controller);
            }

            if (controller == "IndexFatura") {
                await populaTabelaFaturas(order, controller);
            }
        }

    } catch (error) {
        spin(false);
        throw message(`Falha ao listar registros: ${error}`);
    }
}

/**
 * Detalhes
 * @param {*} id 
 * @param {*} controller 
 * @returns 
 */
async function show(id, controller) {
    try {
        const package = {
            controller: controller,
            data: {
                id: id
            }
        };

        const order = await bridge(package);

        if (order) {
            spin(false);
            return await order;
        }

    } catch (error) {
        spin(false);
        throw message(`Falha: ${error}`);
    }
}

/**
 * Deletar 
 * @param {*} id 
 * @param {*} controller 
 * @returns 
 */
async function deletarRegistro(id, controller) {
    spin(true);

    try {
        const package = {
            controller: controller,
            data: {
                id: id
            }
        };

        const order = await bridge(package);

        if (order) {
            if (order.response.hasOwnProperty('warning')) {
                spin(false);
                Swal.fire({
                    text: order.response.warning,
                    icon: 'error',
                });

                return false;
            }

            if (order.response.hasOwnProperty('error')) {
                spin(false);
                Swal.fire({
                    text: order.response.error,
                    icon: 'error',
                });

                return false;
            }

            if (controller == "DeleteCadastro") {
                return await index("IndexCadastro");
            }

            if (controller == "DeleteAssinatura") {
                return await index("IndexAssinatura");
            }

            if (controller == "DeleteFatura") {
                return await index("IndexFatura");
            }
        }

    } catch (error) {
        spin(false);
        throw message(`Falha ao deletar registro: ${error}`);
    }
}

/**
 * Cadastros
 * @param {*} order 
 * @param {*} controller 
 */
async function populaTabelaCadastros(order, controller) {
    const table = $(`.${controller} tbody`).empty();
    const trClass = 'border-2 border-terciary bg-white';
    const tdClass = 'p-2 items-center text-md text-sm text-quartenary';
    const svgDeletePath = await html("/assets/svg/iconDelete.svg");
    const svgEditPath = await html("/assets/svg/iconUpdate.svg");

    $.each(order.response, function (key, api) {
        let onClickBtDelete = `onclick=\"deletarRegistro('${api.id}', 'DeleteCadastro')\"`;
        let tdButtonDelete = `<button title='Deletar Registro' ${onClickBtDelete}>${svgDeletePath}</button>`;
        let onClickBtEdit = `onclick=\"formularioCadastros('${api.id}')\"`;
        let tdButtonEdit = `<button title='Alterar Registro' ${onClickBtEdit}>${svgEditPath}</button>`;
        let dataCreated = formatDate(api.created_at, 'pt');

        let row = $(`<tr class='${trClass}' ></tr>`);
        row.append(`<td class='${tdClass}'>${dataCreated}</td>`);
        row.append(`<td class='${tdClass}'>${api.id}</td>`);
        row.append(`<td class='${tdClass}'>${api.nome}</td>`);
        row.append(`<td class='${tdClass}'>${api.codigo}</td>`);
        row.append(`<td class='${tdClass}'>${api.email}</td>`);
        row.append(`<td class='${tdClass}'>${api.telefone}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonEdit}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonDelete}</td>`);
        table.append(row);
    });
}

async function formularioCadastros(id = null) {
    spin(true);

    try {
        const form = await html("/src/cadastros/form.php");
        const title = (id ? "Atualizar" : "Cadastrar");

        Swal.fire({
            title: `${title}`,
            html: form,
            confirmButtonText: `${title}`,
            showCancelButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value
                const email = Swal.getPopup().querySelector('#email').value
                const telefone = Swal.getPopup().querySelector('#telefone').value

                if (!nome || !email || !telefone) {
                    Swal.showValidationMessage(`Preencha todos os campos`);
                }

                const result = {
                    nome: nome,
                    email: email,
                    telefone: telefone
                };

                if (id) {
                    result.id = id;
                }

                return result;
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                spin(true);

                const package = {
                    data: result.value,
                    controller: (id ? "UpdateCadastro" : "StoreCadastro")
                };

                try {
                    const order = await bridge(package);
                    if (order) {
                        spin(false);

                        if (order.status == 422) {
                            Swal.fire({
                                text: "Dados inválidos",
                                icon: 'error',
                            });

                            return false;
                        }

                        //spin(false);
                        await index('IndexCadastro');
                        await index('IndexAssinatura');
                        await index('IndexFatura');
                    }
                } catch (error) {
                    spin(false);
                    throw message(`Falha : ${error}`);
                }
            }
        });

        spin(false);

        //Show
        if (id) {
            spin(true);
            const showData = await show(id, "ShowCadastro");

            $("#nome").val(showData.response.nome);
            $("#email").val(showData.response.email);
            $("#telefone").val(showData.response.telefone);
        }

    } catch (error) {
        spin(false);
        throw message(`Falha ao renderizar modal: ${error}`);
    }
}

/**
 * Assinaturas
 * @param {*} order 
 * @param {*} controller 
 */
async function populaTabelaAssinaturas(order, controller) {
    const table = $(`.${controller} tbody`).empty();
    const trClass = 'border-2 border-terciary bg-white';
    const tdClass = 'p-2 items-center text-md text-sm text-quartenary';
    const svgDeletePath = await html("/assets/svg/iconDelete.svg");
    const svgEditPath = await html("/assets/svg/iconUpdate.svg");

    console.log(order.response);

    $.each(order.response, function (key, api) {
        let onClickBtDelete = `onclick=\"deletarRegistro('${api.id}', 'DeleteAssinatura')\"`;
        let tdButtonDelete = `<button title='Deletar Registro' ${onClickBtDelete}>${svgDeletePath}</button>`;
        let onClickBtEdit = `onclick=\"formularioAssinaturas('${api.id}')\"`;
        let tdButtonEdit = `<button title='Alterar Registro' ${onClickBtEdit}>${svgEditPath}</button>`;
        let dataCreated = formatDate(api.created_at, 'pt');
        let dataVencimento = formatDate(api.data_vencimento, 'pt');
        let valor = formatarMoedaBRL(api.valor);

        let row = $(`<tr class='${trClass}' ></tr>`);
        row.append(`<td class='${tdClass}'>${dataCreated}</td>`);
        row.append(`<td class='${tdClass}'>${api.id}</td>`);
        row.append(`<td class='${tdClass}'>${api.cadastro.nome}</td>`);
        row.append(`<td class='${tdClass}'>${api.cadastro.codigo}</td>`);
        row.append(`<td class='${tdClass}'>${api.descricao}</td>`);
        row.append(`<td class='${tdClass}'>${valor}</td>`);
        row.append(`<td class='${tdClass}'>${dataVencimento}</td>`);
        row.append(`<td class='${tdClass}'>${api.flag_assinado}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonEdit}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonDelete}</td>`);
        table.append(row);
    });
}

async function formularioAssinaturas(id = null) {
    spin(true);
    try {
        const form = await html("/src/assinaturas/form.php");
        const title = (id ? "Atualizar" : "Cadastrar");

        Swal.fire({
            title: `${title}`,
            html: form,
            confirmButtonText: `${title}`,
            showCancelButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const cadastro_id = Swal.getPopup().querySelector('#cadastro_id').value
                const descricao = Swal.getPopup().querySelector('#descricao').value
                const valor = Swal.getPopup().querySelector('#valor').value
                const flag_assinado = Swal.getPopup().querySelector('#flag_assinado').value
                const data_vencimento = Swal.getPopup().querySelector('#data_vencimento').value

                if (!cadastro_id || !descricao || !valor || !flag_assinado || !data_vencimento) {
                    Swal.showValidationMessage(`Preencha todos os campos`);
                }

                const result = {
                    cadastro_id: cadastro_id,
                    descricao: descricao,
                    valor: valor,
                    flag_assinado: flag_assinado,
                    data_vencimento: data_vencimento,
                };

                if (id) {
                    result.id = id;
                }

                return result;
            },
            didOpen: () => {
                $('#valor').maskMoney({
                    thousands: '.',
                    decimal: ','
                });
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                spin(true);

                const package = {
                    data: result.value,
                    controller: (id ? "UpdateAssinatura" : "StoreAssinatura")
                };

                try {
                    const order = await bridge(package);
                    if (order) {
                        spin(false);

                        if (order.status == 422) {
                            Swal.fire({
                                text: "Dados inválidos",
                                icon: 'error',
                            });

                            return false;
                        }

                        await index('IndexAssinatura');
                        await index('IndexFatura');
                    }
                } catch (error) {
                    spin(false);
                    throw message(`Falha : ${error}`);
                }
            }
        });

        spin(false);

        //Show
        if (id) {
            spin(true);
            const showData = await show(id, "ShowAssinatura");

            $("#descricao").val(showData.response.descricao);
            $("#valor").val(showData.response.valor);
            $("#data_vencimento").val(showData.response.data_vencimento);
            $("#flag_assinado").val(showData.response.flag_assinado).change();
            $("#cadastro_id").val(showData.response.cadastro_id).change();
        }

    } catch (error) {
        spin(false);
        throw message(`Falha ao renderizar modal: ${error}`);
    }
}

/**
 *  Faturas
 * @param {*} order 
 * @param {*} controller 
 */
async function populaTabelaFaturas(order, controller) {
    const table = $(`.${controller} tbody`).empty();
    const trClass = 'border-2 border-terciary bg-white';
    const tdClass = 'p-2 items-center text-md text-sm text-quartenary';
    const svgDeletePath = await html("/assets/svg/iconDelete.svg");
    const svgEditPath = await html("/assets/svg/iconUpdate.svg");

    $.each(order.response, function (key, api) {
        let onClickBtDelete = `onclick=\"deletarRegistro('${api.id}', 'DeleteFatura')\"`;
        let tdButtonDelete = `<button title='Deletar Registro' ${onClickBtDelete}>${svgDeletePath}</button>`;
        let onClickBtEdit = `onclick=\"formularioFaturas('${api.id}')\"`;
        let tdButtonEdit = `<button title='Alterar Registro' ${onClickBtEdit}>${svgEditPath}</button>`;
        let dataCreated = formatDate(api.created_at, 'pt');
        let dataVencimento = formatDate(api.data_vencimento, 'pt');
        let valor = formatarMoedaBRL(api.valor);

        let row = $(`<tr class='${trClass}' ></tr>`);
        row.append(`<td class='${tdClass}'>${dataCreated}</td>`);
        row.append(`<td class='${tdClass}'>${api.id}</td>`);
        row.append(`<td class='${tdClass}'>${api.cadastro.nome}</td>`);
        row.append(`<td class='${tdClass}'>${api.cadastro.codigo}</td>`);
        row.append(`<td class='${tdClass}'>${api.assinatura.descricao}</td>`);
        row.append(`<td class='${tdClass}'>${api.descricao}</td>`);
        row.append(`<td class='${tdClass}'>${valor}</td>`);
        row.append(`<td class='${tdClass}'>${dataVencimento}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonEdit}</td>`);
        row.append(`<td class='${tdClass}'>${tdButtonDelete}</td>`);
        table.append(row);
    });
}

async function formularioFaturas(id = null) {
    spin(true);
    try {
        const form = await html("/src/faturas/form.php");
        const title = (id ? "Atualizar" : "Cadastrar");

        Swal.fire({
            title: `${title}`,
            html: form,
            confirmButtonText: `${title}r`,
            showCancelButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const cadastro_id = Swal.getPopup().querySelector('#cadastro_id').value
                const assinatura_id = Swal.getPopup().querySelector('#assinatura_id').value
                const descricao = Swal.getPopup().querySelector('#descricao').value
                const data_vencimento = Swal.getPopup().querySelector('#data_vencimento').value
                const valor = Swal.getPopup().querySelector('#valor').value

                if (!cadastro_id || !descricao || !valor || !assinatura_id || !data_vencimento) {
                    Swal.showValidationMessage(`Preencha todos os campos`);
                }

                const result = {
                    cadastro_id: cadastro_id,
                    descricao: descricao,
                    valor: valor,
                    assinatura_id: assinatura_id,
                    data_vencimento: data_vencimento,
                };

                if (id) {
                    result.id = id;
                }

                return result;
            },
            didOpen: () => {
                $('#valor').maskMoney({
                    thousands: '.',
                    decimal: ','
                });
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                spin(true);

                const package = {
                    data: result.value,
                    controller: (id ? "UpdateFatura" : "StoreFatura")
                };

                try {
                    const order = await bridge(package);
                    if (order) {
                        spin(false);

                        if (order.status == 422) {
                            Swal.fire({
                                text: "Dados inválidos",
                                icon: 'error',
                            });

                            return false;
                        }

                        spin(false);
                        return await index('IndexFatura');
                    }
                } catch (error) {
                    spin(false);
                    throw message(`Falha : ${error}`);
                }
            }
        });

        spin(false);

        //Show
        if (id) {
            spin(true);
            const showData = await show(id, "ShowFatura");

            $("#descricao").val(showData.response.descricao);
            $("#valor").val(showData.response.valor);
            $("#data_vencimento").val(showData.response.data_vencimento);
            $("#assinatura_id").val(showData.response.assinatura_id).change();
            $("#cadastro_id").val(showData.response.cadastro_id).change();
        }

    } catch (error) {
        spin(false);
        throw message(`Falha ao renderizar modal: ${error}`);
    }
}