function setTableAccount(items, table){

	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	var tempTotal = 0, tempTotal2 = 0;
	var downpayment = 0;
	var atrasadoDownpayment = 0;
	var atrasadoLoan = 0;
	var loan = 0;
	var sales = 0;
	
	for(i=0;i<items.length;i++){
		var item = items[i];
		if( item.Sign_transaction == "1"){
			tempTotal += parseFloat(item.Amount);
		}
		if (item.Sign_transaction == "-1") {
			tempTotal2 += parseFloat(item.Amount);
		}
		if( item.Concept_Trxid.trim() == "Down Payment" && item.Type.trim() == "Schedule Payment"){
			downpayment += parseFloat(item.Amount);
			atrasadoDownpayment += parseFloat(item.Overdue_Amount);
		}
		if( item.Concept_Trxid.trim() == "Sale"){
			sales += parseFloat(item.Amount);
		}
		if (item.Concept_Trxid.trim() == "Loan") {
			loan += parseFloat(item.Amount);
			atrasadoLoan += parseFloat(item.Overdue_Amount);
		}
	}
	balance = tempTotal - tempTotal2;

	//Actualiza el encabezado de las tablas 
	$('#' + table +  ' tbody tr td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + downpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + loan.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + atrasadoDownpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + atrasadoLoan.toFixed(2));
	
}