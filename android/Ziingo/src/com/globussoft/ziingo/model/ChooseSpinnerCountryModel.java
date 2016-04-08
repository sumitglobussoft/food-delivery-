package com.globussoft.ziingo.model;

public class ChooseSpinnerCountryModel {	
	
	public String Spinner_Country = "";
	public String Spinner_CountryId = "";
	
	
	public String getSpinner_Country() {
		return Spinner_Country;
	}

	public void setSpinner_Country(String spinner_Country) {
		Spinner_Country = spinner_Country;
	}

	public String getSpinner_CountryId() {
		return Spinner_CountryId;
	}

	public void setSpinner_CountryId(String spinner_CountryId) {
		Spinner_CountryId = spinner_CountryId;
	}	
	

	public ChooseSpinnerCountryModel() {
	}

	public ChooseSpinnerCountryModel(String Spinner_State, String Spinner_Country,
			String Spinner_City,
			String Spinner_CountryId) {
		
		this.Spinner_Country = Spinner_Country;
		this.Spinner_CountryId = Spinner_CountryId;
		

	}

	@Override
	public String toString() 
	{
		return "ChooseLocationModel [ Spinner_Country = " + Spinner_Country + ", Spinner_State = "
				+ ", Spinner_location = " + Spinner_CountryId + 
				", Spinner_country_prompt = "+" ]";
	}



}
