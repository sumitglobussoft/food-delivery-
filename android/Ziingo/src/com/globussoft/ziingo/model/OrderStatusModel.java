package com.globussoft.ziingo.model;

public class OrderStatusModel 
{	

	public String Os_Pr_name = "";
	public String Os_Pr_qnty = "";
	public String Os_Pr_amt = "";
	
	public OrderStatusModel() { 
	}

	public OrderStatusModel(String Os_Pr_name, String Os_Pr_qnty, String Os_Pr_amt) 
	{		
		this.Os_Pr_name = Os_Pr_name;
		this.Os_Pr_qnty = Os_Pr_qnty;
		this.Os_Pr_amt = Os_Pr_amt;		
	}
	
	public String getOs_Pr_name() {
		return Os_Pr_name;
	}

	public void setOs_Pr_name(String Os_Pr_name) {
		this.Os_Pr_name = Os_Pr_name;
	}
	
	public String getOs_Pr_qnty() {
		return Os_Pr_qnty;
	}

	public void setOs_Pr_qnty(String Os_Pr_qnty) {
		this.Os_Pr_qnty = Os_Pr_qnty;
	}
	
	public String getOs_Pr_amt() {
		return Os_Pr_amt;
	}

	public void setOs_Pr_amt(String Os_Pr_amt) {
		this.Os_Pr_amt = Os_Pr_amt;
	}
	
	
}
