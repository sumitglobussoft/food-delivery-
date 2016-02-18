package com.globussoft.ziingo.twitterlib;

import org.json.JSONObject;

public interface TwitterRequestCallBack {

	public void onSuccess(String jsonResult);
	
	public void onSuccess(JSONObject jsonObject);

	public void onFailure(Exception e);

    
}
