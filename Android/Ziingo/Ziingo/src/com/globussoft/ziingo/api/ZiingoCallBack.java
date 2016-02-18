package com.globussoft.ziingo.api;

import org.json.JSONObject;

public interface ZiingoCallBack {

	public void onSuccess(JSONObject result);

	public void onFailure(Exception exception);

}
