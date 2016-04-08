package com.globussoft.ziingo.model;

public class FilterModel_RestName {

	public String filter_restName = "";
	public String filter_restID = "";
	public String filter_restStatus = ""; 
	
	public String getFilter_restID() {
		return filter_restID;
	}

	public void setFilter_restID(String filter_restID) {
		this.filter_restID = filter_restID;
	}

	public String getFilter_restStatus() {
		return filter_restStatus;
	}

	public void setFilter_restStatus(String filter_restStatus) {
		this.filter_restStatus = filter_restStatus;
	}	
		
	public FilterModel_RestName() {
	}

	public FilterModel_RestName(String filter_restName) {

		this.filter_restName = filter_restName;
		
	}

	public String getfilter_restName() {
		return filter_restName;
	}

	public void setfilter_restName(String filter_restName) {
		this.filter_restName = filter_restName;
	}

	
}
