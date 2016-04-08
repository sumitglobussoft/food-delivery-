package com.globussoft.ziingo.model;

public class OrderHistoryModel {
	
	public String History_OrderId= "";
	
	public String History_HotelName= "";
	public String History_HotelAddress= "";
	public String History_OrderDate= "";
	public String History_OrderTotal= "";	

	public OrderHistoryModel() {
		// TODO Auto-generated constructor stub
	}
	
	public OrderHistoryModel(String History_HotelName, String History_HotelAddress, String History_OrderDate, 
			String History_OrderTotal,String History_OrderId) {
		
		this.History_HotelName = History_HotelName;
		this.History_HotelAddress = History_HotelAddress;
		this.History_OrderDate = History_OrderDate;
		this.History_OrderTotal = History_OrderTotal;	
		this.History_OrderId = History_OrderId;		
	}
	
	public String getHistory_OrderId() {
		return History_OrderId;
	}

	public void setHistory_OrderId(String history_OrderId) {
		History_OrderId = history_OrderId;
	}

	public String getHistory_HotelName() {
		return History_HotelName;
	}

	public void setHistory_HotelName(String History_HotelName) {
		this.History_HotelName = History_HotelName;
	}
	
	public String getHistory_HotelAddress() {
		return History_HotelAddress;
	}

	public void setHistory_HotelAddress(String History_HotelAddress) {
		this.History_HotelAddress = History_HotelAddress;
	}
	
	public String getHistory_OrderDate() {
		return History_OrderDate;
	}

	public void setHistory_OrderDate(String History_OrderDate) {
		this.History_OrderDate = History_OrderDate;
	}
	
	public String getHistory_OrderTotal() {
		return History_OrderTotal;
	}

	public void setHistory_OrderTotal(String History_OrderTotal) {
		this.History_OrderTotal = History_OrderTotal;
	}

}
