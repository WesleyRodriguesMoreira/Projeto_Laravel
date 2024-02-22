

// Receber o id do campo
let inputValor = document.getElementById('valor');

// Aguardar o usuário digitar
inputValor.addEventListener('input', function() {
    // Função para adicionar pontos como separadores de milhares
    function addMilharSeparators(valor) {
        return valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Obter o valor removendo caracteres não numéricos
    let valueValor = this.value.replace(/[^\d]/g, '');

    // Adicionar a vírgula e até dois dígitos se houver centavos
    var formattedValor = addMilharSeparators(valueValor.slice(0, -2)) + ',' + valueValor.slice(-2);

    // Atualizar o valor no campo
    this.value = formattedValor;
});

function comfirmarExclusao(event, contaId){
    event.preventDefault();
    Swal.fire({
       title: "Tem certeza?",
       text: 'Você não podera reverter isso!',
       icon: 'warning', 
       showCancelButton: true,
       cancelButtonColor: '#0d6efd',
       cancelButtonText: 'Cancelar',
       confirmButtonColor: '#dc3545',
       confirmButtonText: 'Sim,excluir!',
    }).then((result) =>{
        if(result.isConfirmed){
            document.getElementById('formExcluir' + contaId).submit();
        }
    })
};
