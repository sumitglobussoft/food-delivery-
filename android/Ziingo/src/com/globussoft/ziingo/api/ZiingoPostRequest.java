package com.globussoft.ziingo.api;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.RetryPolicy;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.twitterlib.Const;

/*
 * this class is used for get Json data from given web services url
 */

public class ZiingoPostRequest {

	// get Json from given url

	ZiingoCallBack ziingocallback;

	Context activity;

	public ZiingoPostRequest(Context activity) {

		this.activity = activity;

	}

	public void executeRequest(String url,
			final java.util.Map<String, String> nameValuePair,
			final ZiingoCallBack ziingocallback) {

		System.out.println("executeRequest ");

		this.ziingocallback = ziingocallback;

		RequestQueue queue = Volley.newRequestQueue(activity);

		StringRequest sr = new StringRequest(Request.Method.POST, url,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						JSONObject jsonObject;

						try {

							jsonObject = new JSONObject(response);

							ziingocallback.onSuccess(jsonObject);

						} catch (JSONException e) {
							ziingocallback.onFailure(e);
						}

						System.out.println("executedRequest "+response);

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						ziingocallback.onFailure(error);
					}
				}) {

			protected java.util.Map<String, String> getParams()
					throws AuthFailureError {
				return nameValuePair;
			};
		};

		sr.setRetryPolicy((RetryPolicy) new DefaultRetryPolicy(15000,
				DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
				DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));

		queue.add(sr);

	}

	// check whether network is available or not
	public boolean isNetworkAvailable(Context activity) {
		ConnectivityManager connectivity = (ConnectivityManager) activity
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		if (connectivity == null) {
			return false;
		} else {
			NetworkInfo[] info = connectivity.getAllNetworkInfo();
			if (info != null) {
				for (int i = 0; i < info.length; i++) {
					if (info[i].getState() == NetworkInfo.State.CONNECTED) {
						return true;
					}
				}
			}
		}
		return false;
	}

}
