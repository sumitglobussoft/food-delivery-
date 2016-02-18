package com.globussoft.ziingo.model;

public class ChooseSpinnerCountryModel {	
	
	public String Spinner_Country = "";
	public String Spinner_locationId = "";

	public String getSpinner_Country() {
		return Spinner_Country;
	}

	public void setSpinner_Country(String spinner_Country) {
		Spinner_Country = spinner_Country;
	}

	public String getSpinner_locationId() {
		return Spinner_locationId;
	}

	public void setSpinner_locationId(String spinner_locationId) {
		Spinner_locationId = spinner_locationId;
	}	
	

	public ChooseSpinnerCountryModel() {
	}

	public ChooseSpinnerCountryModel(String Spinner_State, String Spinner_Country,
			String Spinner_City,
			String Spinner_locationId) {
		
		this.Spinner_Country = Spinner_Country;
		this.Spinner_locationId = Spinner_locationId;
		
	}

	

	@Override
	public String toString() {
		return "ChooseLocationModel [Spinner_Country = " + Spinner_Country + ", Spinner_State = "
				+ ", Spinner_location = " + Spinner_locationId + "]";
	}



}
