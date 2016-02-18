package com.globussoft.ziingo.model;

public class FilterModel_Cuisine {

	public String filter_cuisine = "";
	public String filter_cuisine_id = "";
	public String filter_cuisine_status = "";
	
	public boolean isChecekd;
	public boolean isChecekd() {
		return isChecekd;
	}
	
	public void setChecekd(boolean isChecekd) {
		this.isChecekd = isChecekd;
	}
	
	
	public FilterModel_Cuisine() {
	}

	public FilterModel_Cuisine(String filter_cuisine, String filter_cuisine_id, String filter_cuisine_status) {

		this.filter_cuisine = filter_cuisine;
		this.filter_cuisine_id = filter_cuisine_id;
		this.filter_cuisine_status = filter_cuisine_status;
		
	}
	

	public String getfilter_cuisine() {
		return filter_cuisine;
	}

	public void setfilter_cuisine(String filter_cuisine) {
		this.filter_cuisine = filter_cuisine;
	}
	
	public String getFilter_cuisine_id() {
		return filter_cuisine_id;
	}

	public void setFilter_cuisine_id(String filter_cuisine_id) {
		this.filter_cuisine_id = filter_cuisine_id;
	}

	public String getFilter_cuisine_status() {
		return filter_cuisine_status;
	}

	public void setFilter_cuisine_status(String filter_cuisine_status) {
		this.filter_cuisine_status = filter_cuisine_status;
	}

	@Override
	public String toString() {
		return "FilterModel [filter_cuisine = " + filter_cuisine + 
				"filter_cuisine_id = " + filter_cuisine_id +
				"filter_cuisine_status = " + filter_cuisine_status +"]";
	}



}
