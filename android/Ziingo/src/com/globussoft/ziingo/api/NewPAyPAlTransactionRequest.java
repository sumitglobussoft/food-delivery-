/*package com.globussoft.ziingo.api;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import javax.net.ssl.HttpsURLConnection;

import android.os.AsyncTask;

import com.globussoft.ziingo.twitterlib.TwitterRequestCallBack;
import com.globussoft.ziingo.utills.PaypalConfig;

public class NewPAyPAlTransactionRequest {

	TwitterRequestCallBack twitterRequestCallBack;

	public NewPAyPAlTransactionRequest(
			TwitterRequestCallBack twitterRequestCallBack) {

		this.twitterRequestCallBack = twitterRequestCallBack;

	}

	public void executeThisRequest(String oauthToken, String oauthVerifier) {

		new RequestAsync().execute(oauthToken, oauthVerifier);

	}

	public class RequestAsync extends AsyncTask<String, Void, Void> {

		@Override
		protected Void doInBackground(String... params) {

			String response = null;

			try {

				// perams

				// String urlTimeline = MainSingleTon.accessTokenPost ;

				String authData = "OAuth " + PaypalConfig.PAYPAL_CLIENT_ID
						+ ":" + PaypalConfig.PAYPAL_CLIENT_SECRET;

				myprint("authData : " + authData);

				URL obj = new URL(
						"https://api.sandbox.paypal.com/v1/oauth2/token");

				HttpsURLConnection con = (HttpsURLConnection) obj
						.openConnection();

				con.setRequestMethod("POST");

				con.addRequestProperty("Authorization", "Bearer " + authData);

				con.addRequestProperty("grant_type", "client_credentials");

				con.addRequestProperty("Host", "https://api.paypal.com/");

				con.addRequestProperty("Content-Type", "application/x-www-form-urlencoded");

				response = readResponse(con);

				myprint("jsonString response = " + response);

				String string = response;

				string = "[" + response + "]";

				if (response == null) {

					twitterRequestCallBack.onFailure(new Exception());

				} else {

					twitterRequestCallBack.onSuccess(response);
				}

			} catch (Exception e) {

				e.printStackTrace();

				twitterRequestCallBack.onFailure(new Exception());

				myprint("Exception = =    " + e);

			}

			return null;
		}

	}

	// Reads a response for a given connection and returns it as a string.
	public String readResponse(HttpsURLConnection connection) {

		try {

			int responseCode = connection.getResponseCode();

			myprint("readResponse connection.getResponseCode()   "
					+ responseCode);

			String jsonString = null;

			if (responseCode == HttpURLConnection.HTTP_OK) {

				InputStream linkinStream = connection.getInputStream();

				ByteArrayOutputStream baos = new ByteArrayOutputStream();

				int j = 0;

				while ((j = linkinStream.read()) != -1) {

					baos.write(j);

				}

				byte[] data = baos.toByteArray();

				jsonString = new String(data);

			}

			// myprint("readResponse jsonString   " + jsonString);

			return jsonString;

		} catch (IOException e) {

			// twitterRequestCallBack.onFailure(e);

			e.printStackTrace();

			myprint("readResponse IOExceptionException   " + e);

			return null;
		}

	}

	void myprint(Object msg) {

		System.out.println(msg.toString());

	}

}
*/