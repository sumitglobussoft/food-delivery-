package com.globussoft.ziingo.twitterlib;

public interface TwtSocioCallBack {

	public void onSuccess(TwtSocioUserDatas twtSocioUserDatas);

	public void onFailure(Exception exception);

}
