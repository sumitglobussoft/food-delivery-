package com.globussoft.ziingo.model;

public class ChooseSpinnerLocationModel {
	
	
	public String Spinner_Loc = "";
	public String Spinner_Loc_id = "";
	
	public String getSpinner_Loc() {
		return Spinner_Loc;
	}

	public void setSpinner_Loc(String spinner_Loc) {
		Spinner_Loc = spinner_Loc;
	}

	
	public String getSpinner_Loc_id() {
		return Spinner_Loc_id;
	}

	public void setSpinner_Loc_id(String spinner_Loc_id) {
		Spinner_Loc_id = spinner_Loc_id;
	}

	
	

	public ChooseSpinnerLocationModel() {
	}

	public ChooseSpinnerLocationModel(String Spinner_Loc, String Spinner_Loc_id) {
		
		this.Spinner_Loc = Spinner_Loc;
		this.Spinner_Loc_id = Spinner_Loc_id;
		
	}

	

	@Override
	public String toString() {
		return "ChooseSpinnerLocationModel [ Spinner_Loc = "+ Spinner_Loc+ ", Spinner_Loc_id = " + Spinner_Loc_id
				+ "]";
	}







}
