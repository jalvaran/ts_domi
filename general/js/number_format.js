    function number_format(numero,decimals=0){
        return (numero.toLocaleString('us', {minimumFractionDigits: decimals, maximumFractionDigits: decimals}))
    }