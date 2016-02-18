package com.globussoft.ziingo;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.content.pm.Signature;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.FacebookSdk;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.login.LoginBehavior;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.twitterlib.TwitterRequestCallBack;
import com.globussoft.ziingo.twitterlib.TwitterUserShowRequest;
import com.globussoft.ziingo.twitterlib.TwtSocioCallBack;
import com.globussoft.ziingo.twitterlib.TwtSocioInitialize;
import com.globussoft.ziingo.twitterlib.TwtSocioLoginDialog;
import com.globussoft.ziingo.twitterlib.TwtSocioUserDatas;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantData;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;
import com.globussoft.ziingo.utills.Utilsss;

public class LoginActivity extends Activity {

	EditText email, password;

	ConnectionDetector cd;

	CallbackManager callbackManager;
	AccessToken myAccessToken = null;
	String extendedAccessToken = null;

	// Shared Preferences
	public static SharedPreferences pref;

	// Editor for Shared preferences
	Editor editor;

	// Shared pref mode
	int PRIVATE_MODE = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);

		FacebookSdk.sdkInitialize(LoginActivity.this.getApplicationContext());

		TwtSocioInitialize.initialize(ConstantData.TWITTER_KEY,
				ConstantData.TWITTER_SECRET, ConstantData.oauth_callbackURL);
		// TwtSocioInitialize.initialize("rpQuhfPPCnCEMv3f5PmzgoCp5",
		// "vqUBET5x61i6EoIx9lHEt8DkdQUhC6MJG2sOafTvjjJ34oFK1Q",
		// "http://placeholder.com");
		cd = new ConnectionDetector(getApplicationContext());

		callbackManager = CallbackManager.Factory.create();

		loggIn();

	}

	protected void sharedPrefernces() {
		pref = getSharedPreferences("Login Credentials", MODE_PRIVATE);
		editor = pref.edit();
		editor.putString("Username", Singleton.name);
		editor.putString("email", Singleton.email);
		editor.putString("Password", Singleton.pass);
		editor.putString("social_id", Singleton.social_id);
		editor.putString("user_id", Singleton.user_id);
		editor.putBoolean("Login_status", true);
		
		Singleton.LoginStatus = pref.getBoolean("Login_status", true);
		editor.commit();		
				
		System.out.println("******** Shared Preference ********");
		System.out.println("Username " + Singleton.name);
		System.out.println("email " + Singleton.email);
		System.out.println("Password " + Singleton.pass);
		System.out.println("social_id " + Singleton.social_id);
		System.out.println("user_id " + Singleton.user_id);
		System.out.println("******** ******** ******** ********");
	}

	private void loggIn() {

		email = (EditText) findViewById(R.id.email);
		password = (EditText) findViewById(R.id.password);
		ImageView login_btn = (ImageView) findViewById(R.id.login_btn);
		ImageView login_fb = (ImageView) findViewById(R.id.login_fb);
		ImageView login_twt = (ImageView) findViewById(R.id.login_gplus);
		ImageView close = (ImageView) findViewById(R.id.imageView4);

		Singleton.email = email.getText().toString();
		Singleton.pass = password.getText().toString();

		login_fb.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				LoginWithFB();

			}
		});

		login_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				if (cd.isConnectingToInternet()) 
				{
					if (email.getText().toString().length() > 1
							&& password.getText().toString().length() > 1) 
					{

						Singleton.email = email.getText().toString();
						Singleton.pass = password.getText().toString();

						logInRequest(Singleton.email, Singleton.pass, "1");

					} 
					else 
					{
						Toast.makeText(getApplicationContext(),"Fill all the details", Toast.LENGTH_LONG).show();
					}

				} 
				else 
				{
					Toast.makeText(getApplicationContext(), "Connect to Internet", Toast.LENGTH_LONG).show();
				}

			}
		});

		login_twt.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				LoginWithTWT();

			}
		});

		close.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				
				finish();
			}
		});

	}

	private void logInRequest(final String email, final String password, final String type) {

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_login,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("login response" + response);
						try 
						{
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								JSONObject obj = json.getJSONObject("data");

								Singleton.user_id = obj.getString("user_id");

								System.out.println("message >>>>>>>>>" + msg);
								System.out.println("user_id >>>>>>>>" + Singleton.user_id);

								sharedPrefernces();

								Intent intent = new Intent(getApplicationContext(), Choose_spinner_country.class);
									startActivity(intent);	

								// finish();

							}

							else 
							{
								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
					}
				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// progress.setVisibility(View.INVISIBLE);
					}
				}) 
		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("email", email);
				params.put("password", password);
				params.put("type", type);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}
		};
		queue.add(sr);

	}

	// generate hashkey

	{
		PackageInfo info;

		try {

			info = getPackageManager().getPackageInfo("com.globussoft.ziingo",
					PackageManager.GET_SIGNATURES);

			for (Signature signature : info.signatures) {

				MessageDigest md;
				md = MessageDigest.getInstance("SHA");
				md.update(signature.toByteArray());
				String something = new String(Base64.encode(md.digest(), 0));
				Log.e("hash key>>>>>>>>>>>>>>>", something);
				System.out.println("keyy hashhhh " + something);
			}

		} catch (NameNotFoundException e1) {
			Log.e("name not found", e1.toString());
		} catch (NoSuchAlgorithmException e) {
			Log.e("no such an algorithm", e.toString());
		} catch (Exception e) {
			Log.e("exception", e.toString());
		}

	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
		callbackManager.onActivityResult(requestCode, resultCode, data);
	}

	// fb login

	public void LoginWithFB() {

		LoginManager.getInstance().setLoginBehavior(LoginBehavior.SUPPRESS_SSO);

		LoginManager.getInstance().logInWithReadPermissions(this,
				Arrays.asList("email", "user_friends", "public_profile"));

		LoginManager.getInstance().registerCallback(callbackManager,
				new FacebookCallback<LoginResult>() {

					@Override
					public void onSuccess(final LoginResult loginResult) {

						myAccessToken = loginResult.getAccessToken();

						// Profile.fetchProfileForCurrentAccessToken();

						if (Singleton.social_id == null) {
							Singleton.social_id = loginResult.getAccessToken()
									.getUserId();
						}

						// System.out.println("social_id >>>>>>>> " +
						// Singleton.social_id);

						GraphRequest request = GraphRequest.newMeRequest(
								loginResult.getAccessToken(),
								new GraphRequest.GraphJSONObjectCallback() {

									@Override
									public void onCompleted(JSONObject object,
											GraphResponse response) {
										// TODO Auto-generated

										Singleton.name = object
												.optString("name");

										System.out.println("FB_name = "
												+ Singleton.name);

										Singleton.fb_profilePicURL = "https://graph.facebook.com/"
												+ Singleton.social_id
												+ "/picture?type=large";

										try {

											if (Singleton.email == null)

											{

												if (object.has("email")) {

													Singleton.email = object
															.getString("email");
													System.out.println("email "
															+ Singleton.email);

													SignUpActivity SA = new SignUpActivity();

													SA.SignUpRequest_Fb(
															Singleton.email,
															Singleton.social_id
																	.toString(),
															Singleton.name, "2");

													// LoginRequestWithFb(Singleton.social_id,"2");
												} else {
													alertEmail();
												}
											}

											else {
												LoginRequestWithFb(Singleton.social_id,
														"2");
											}

										} catch (JSONException e) {

											e.printStackTrace();
										}

									}

									public void alertEmail() {
										// TODO Auto-generated method stub

										AlertDialog.Builder alert = new AlertDialog.Builder(
												LoginActivity.this);

										final EditText edittext = new EditText(
												LoginActivity.this);
										edittext.setTextColor(Color.BLACK);
										alert.setMessage("Enter Your Email Id");
										// alert.setTitle("Email Id");

										alert.setView(edittext);

										alert.setPositiveButton(
												"OK",
												new DialogInterface.OnClickListener() {
													public void onClick(
															DialogInterface dialog,
															int whichButton) {

														// if
														// (edittext.getText().toString().length()
														// != 0) {

														Singleton.email = edittext
																.getText()
																.toString();

														SignUpActivity SA = new SignUpActivity();

														SA.SignUpRequest_Fb(
																Singleton.email,
																Singleton.social_id
																		.toString(),
																Singleton.name,
																"2");

														// LoginRequestWithFb(Singleton.social_id,"2");

														// }
													}
												});

										alert.setNegativeButton(
												"Cancel",
												new DialogInterface.OnClickListener() {
													public void onClick(
															DialogInterface dialog,
															int whichButton) {

													}
												});

										alert.show();

									}

								});
						request.executeAsync();

						// LoginRequestWithFb(Singleton.email,
						// Singleton.social_id, "2");

						/*
						 * Intent intent = new Intent( getApplicationContext(),
						 * MainActivity.class); startActivity(intent);
						 */

						// finish();

					}

					@Override
					public void onError(FacebookException error) {
						AccessToken.setCurrentAccessToken(null);

					}

					@Override
					public void onCancel() {
						AccessToken.setCurrentAccessToken(null);

					}
				});
	}

	public void LoginWithTWT() {

		TwtSocioLoginDialog twtLogin = new TwtSocioLoginDialog(
				LoginActivity.this, new TwtSocioCallBack() {

					@Override
					public void onSuccess(TwtSocioUserDatas twtSocioUserDatas) {

						System.out
								.println("<<<<<<<<<<<<       ONSUCCESS 1     >>>>>>>>>>>>>");

						System.out
								.println("Login Success twtSocioUserDatas >>>>>>>>> +"
										+ twtSocioUserDatas);

						Singleton.social_id = twtSocioUserDatas.getUserid();

						System.out.println("twtSocioUserDatas >>>>>>>>>>>>>> "
								+ twtSocioUserDatas);

						// ZiingoPostRequest postReq = new
						// ZiingoPostRequest(getApplicationContext());

						LoginRequestWithTwt(Singleton.social_id, "3");
						TwitterUserShowRequest request = new TwitterUserShowRequest(
								twtSocioUserDatas,
								new TwitterRequestCallBack() {

									@Override
									public void onSuccess(JSONObject jsonObject) {
										// TODO Auto-generated method stub

										/*
										 * System.out.println(
										 * "<<<<<<<<<<<<       ONSUCCESS 2     >>>>>>>>>>>>>"
										 * );
										 * 
										 * System.out.println(
										 * " TwitterUserShowRequest jsonObject +"
										 * + jsonObject);
										 * 
										 * //parseJsonResultForAccountData(
										 * jsonObject);
										 * 
										 * 
										 * LoginRequestWithTwt(social_id.toString
										 * (),"3");
										 */
									}

									@Override
									public void onSuccess(String jsonResult) {
										// TODO Auto-generated method stub

										LoginRequestWithTwt(
												Singleton.social_id.toString(),
												"3");
										System.out
												.println("  TwitterUserShowRequest jsonObject +"
														+ jsonResult);

									}

									@Override
									public void onFailure(Exception e) {
										// TODO Auto-generated method stub
										System.out.println("Login Success e +"
												+ e);

									}
								});

						request.executeThisRequest(twtSocioUserDatas
								.getUsername());
					}

					@Override
					public void onFailure(Exception exception) {
						// CommonMethods.showMyToast(getActivity(),
						// "Login failure "+exception);
						System.out.println("Login failure");

					}
				});

		twtLogin.startLogin();

	}

	protected void LoginRequestWithTwt(final String social_id, final String type) {
		// TODO Auto-generated method stub

		System.out.println("Login result");
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());

		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_login,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("login response" + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								JSONObject obj = json.getJSONObject("data");

								String user_id = obj.getString("user_id");

								System.out.println("message >>>>>>>>> " + msg);
								System.out.println("twt_id >>>>>>>>"
										+ Singleton.social_id);
								System.out
										.println("user_id >>>>>>>>" + user_id);

								sharedPrefernces();

								Intent intent = new Intent(
										getApplicationContext(),
										Choose_spinner_country.class);
									startActivity(intent);	

								finish();

								/*
								 * Intent intent = new Intent(
								 * getApplicationContext(), MainActivity.class);
								 * startActivity(intent);
								 */

							}

							else {

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}
						// progress.setVisibility(View.INVISIBLE);
					}
				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// progress.setVisibility(View.INVISIBLE);
						System.out.println("Errrrorrrrrrr" + error);
					}
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("social_id", social_id);
				params.put("type", type);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}
		};
		queue.add(sr);

	}

	protected void LoginRequestWithFb(final String social_id, final String type) {
		// TODO Auto-generated method stub

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_login,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("login response" + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								JSONObject obj = json.getJSONObject("data");

								Singleton.user_id = obj.getString("user_id");

								System.out.println("message >>>>>>>>> " + msg);
								System.out.println("fb_id >>>>>>>> "
										+ Singleton.social_id);
								System.out.println("Singleton.user_id >>>>>>>>"
										+ Singleton.user_id);

								sharedPrefernces();						

								
								Intent intent = new Intent(
										getApplicationContext(),
										Choose_spinner_country.class);
									startActivity(intent);								

								
							}

							else {

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();

								/*
								 * System.out.println(
								 * "<<<<<<<<<<<  First SignUp, Then Login  >>>>>>>>>"
								 * );
								 * 
								 * SignUpActivity signUpActivity = new
								 * SignUpActivity();
								 * signUpActivity.SignUpRequest_Fb
								 * (email.toString(), social_id.toString(),
								 * "2");
								 * 
								 * 
								 * RequestQueue queue =
								 * Volley.newRequestQueue(getApplicationContext
								 * ()); StringRequest sr = new
								 * StringRequest(Request.Method.POST,
								 * ConstantUrl.Url_main +
								 * ConstantUrl.Url_signup, new
								 * Response.Listener<String>() {
								 * 
								 * @Override public void onResponse(String
								 * response) {
								 * 
								 * System.out.println("SignUp response" +
								 * response); try { JSONObject json = new
								 * JSONObject(response);
								 * 
								 * String msg = json.getString("message");
								 * 
								 * if (json.getString("code").equals("200")) {
								 * 
								 * Singleton.user_id =
								 * json.getString("user_id");
								 * 
								 * System.out.println("message >>>>>>>>>" +
								 * msg); System.out.println("id >>>>>>>>" +
								 * Singleton.social_id);
								 * System.out.println("Singleton.user_id >>>>>> "
								 * + Singleton.user_id);
								 * 
								 * 
								 * System.out.println("message >>>>>>>>>" +
								 * msg); System.out.println("user_id >>>>>>>>" +
								 * user_id);
								 * 
								 * 
								 * Intent intent = new Intent(
								 * getApplicationContext(), MainActivity.class);
								 * startActivity(intent);
								 * 
								 * // finish();
								 * 
								 * }
								 * 
								 * else {
								 * 
								 * Toast.makeText(getApplicationContext(), msg,
								 * Toast.LENGTH_LONG).show(); }
								 * 
								 * } catch (Exception e) { e.printStackTrace();
								 * } //progress.setVisibility(View.INVISIBLE); }
								 * }, new Response.ErrorListener() {
								 * 
								 * @Override public void
								 * onErrorResponse(VolleyError error) {
								 * //progress.setVisibility(View.INVISIBLE); }
								 * }) {
								 * 
								 * @Override protected Map<String, String>
								 * getParams() { Map<String, String> params =
								 * new HashMap<String, String>();
								 * //params.put("email", email);
								 * params.put("social_id", social_id);
								 * params.put("type", type);
								 * 
								 * return params; }
								 * 
								 * @Override public Map<String, String>
								 * getHeaders() throws AuthFailureError {
								 * Map<String, String> params = new
								 * HashMap<String, String>();
								 * params.put("Content-Type",
								 * "application/x-www-form-urlencoded"); return
								 * params; } }; queue.add(sr);
								 */
								}

						} catch (Exception e) {
							e.printStackTrace();
						}
						// progress.setVisibility(View.INVISIBLE);
					}
				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// progress.setVisibility(View.INVISIBLE);
					}
				})
		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("social_id", social_id);
				params.put("type", type);
				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}
		};
		
		queue.add(sr);

	}

	public class GetExtendedAccessToken extends AsyncTask<Void, Void, String> {

		@Override
		protected String doInBackground(Void... params) {

			String tokenURL = " https://graph.facebook.com/oauth/access_token?client_id="
					+ getResources().getString(R.string.facebook_app_id)
					+ "&client_secret="
					+ getResources().getString(R.string.facebook_app_secret)
					+ "&grant_type=fb_exchange_token&fb_exchange_token="
					+ myAccessToken.getToken();// CURRENT_ACCESS_TOKEN"

			String dummtoken = Utilsss.getJSONString(tokenURL);

			System.out.println(tokenURL + " EXXXXXXXXXXTEDED ACCESSTOKEN= "
					+ dummtoken);

			dummtoken = dummtoken.substring(dummtoken.indexOf("="),
					dummtoken.indexOf("&"));

			extendedAccessToken = dummtoken.replace("=", "");

			System.out.println("DDSSDDSASDDSF= " + extendedAccessToken);

			return extendedAccessToken;
		}

		@Override
		protected void onPostExecute(String result) {

			super.onPostExecute(result);

			SharedPreferences lifesharedpref = getSharedPreferences("Ziingo",
					Context.MODE_PRIVATE);
			SharedPreferences.Editor editor = lifesharedpref.edit();
			editor.putString("extendedAccesstoken", result);
			editor.commit();
			Singleton.extendedAccestoken = result;

			Intent intent = new Intent(getApplicationContext(),
					UserProfile.class);
			startActivity(intent);

		}
	}

	public class LoginWithTwitter extends AsyncTask<String, Void, Void> {

		JSONObject json;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			runOnUiThread(new Runnable() {
				public void run() {
					// showProgressDialog(Jewelspark_Signin.this);
				}
			});

		}

		@Override
		protected Void doInBackground(String... params) {
			// TODO Auto-generated method stub

			/*
			 * String url = ConstantUrl.Url_main + ConstantUrl.Url_login; //key
			 * and value pair
			 * 
			 * List<NameValuePair> nameValuePair = new
			 * ArrayList<NameValuePair>(1);
			 * 
			 * System.out.println("twitter_login_url BACKGROUND");
			 * 
			 * nameValuePair.add(new BasicNameValuePair("mytoken",
			 * Singleton.mytoken)); nameValuePair.add(new
			 * BasicNameValuePair("social_id", social_id));
			 * nameValuePair.add(new BasicNameValuePair("device_id",
			 * "abcdefghijklmn"));
			 * 
			 * json = parser.getJSONFromUrlByPost(url, nameValuePair);
			 */
			return null;
		}

		@Override
		protected void onPostExecute(Void result) {
			// TODO Auto-generated method stub

			super.onPostExecute(result);

			SharedPreferences lifesharedpref = getSharedPreferences("Ziingo",
					Context.MODE_PRIVATE);
			SharedPreferences.Editor editor = lifesharedpref.edit();
			// editor.putString("extendedAccesstoken", result);
			editor.commit();
			// Singleton.extendedAccestoken = result;

			Intent intent = new Intent(getApplicationContext(),
					UserProfile.class);
			startActivity(intent);

			/*
			 * super.onPostExecute(result); runOnUiThread(new Runnable() {
			 * public void run() {
			 * //cancelProgressDialog(Jewelspark_Signin.this); } });
			 * 
			 * 
			 * System.out.println("Signin Response==" + json);
			 * 
			 * try {
			 * 
			 * if (json.getString("code").equals("100")) {
			 * 
			 * alert = new AlertDialog.Builder(Jewelspark_Signin.this);
			 * 
			 * final EditText edittext = new EditText( Jewelspark_Signin.this);
			 * edittext.setTextColor(Color.BLACK);
			 * alert.setMessage("Enter Your Email Id");
			 * alert.setTitle("Email Id");
			 * 
			 * alert.setView(edittext);
			 * 
			 * alert.setPositiveButton("Send", new
			 * DialogInterface.OnClickListener() { public void
			 * onClick(DialogInterface dialog, int whichButton) { // What ever
			 * you want to do with the value
			 * 
			 * if (edittext.getText().toString().length() != 0) { emailid =
			 * edittext.getText().toString(); new
			 * RegisterWithTwitter().execute(); }
			 * 
			 * } });
			 * 
			 * alert.setNegativeButton("Cancel", new
			 * DialogInterface.OnClickListener() { public void
			 * onClick(DialogInterface dialog, int whichButton) {
			 * 
			 * } });
			 * 
			 * alert.show();
			 * 
			 * } else if (json.getString("message").equals(
			 * "Please complete the mail verification and try again")) {
			 * 
			 * showAlertDialog(Jewelspark_Signin.this,
			 * "Please complete the mail verification and try again");
			 * 
			 * } else if (json.getString("message").contains(
			 * "Login successful")) {
			 * 
			 * showToast(Jewelspark_Signin.this, "Login Successful");
			 * 
			 * JSONObject json_userinfo = json.getJSONObject("data");
			 * 
			 * Singleton.user_name = json_userinfo.getString("user_name");
			 * System.out.println("User Name : " + Singleton.user_name);
			 * 
			 * Singleton.users_credentials_id = json_userinfo
			 * .getString("users_credentials_id");
			 * System.out.println("User Credentails Id : " +
			 * Singleton.users_credentials_id);
			 * 
			 * Singleton.group_id = json_userinfo.getString("group_id");
			 * System.out.println("Group Id : " + Singleton.group_id);
			 * 
			 * Singleton.role = json_userinfo.getString("role");
			 * System.out.println("Role : " + Singleton.role);
			 * 
			 * Singleton.device_id = json_userinfo.getString("device_id");
			 * System.out.println("Device Id : " + Singleton.device_id);
			 * 
			 * Singleton.user_status = json_userinfo .getString("user_status");
			 * System.out .println("User Status : " + Singleton.user_status);
			 * 
			 * Singleton.user_id = json_userinfo.getString("user_id");
			 * System.out.println("User Id : " + Singleton.user_id);
			 * 
			 * Singleton.login_token = json_userinfo .getString("login_token");
			 * System.out .println("Login Token : " + Singleton.login_token);
			 * 
			 * Singleton.facebook_id = json_userinfo .getString("facebook_id");
			 * System.out .println("Facebook Id : " + Singleton.facebook_id);
			 * 
			 * Singleton.secondary_email_id = json_userinfo
			 * .getString("secondary_email_id");
			 * System.out.println("Secondary Email Id : " +
			 * Singleton.secondary_email_id);
			 * 
			 * Singleton.signup_token = json_userinfo
			 * .getString("signup_token"); System.out.println("Sign Up Token : "
			 * + Singleton.signup_token);
			 * 
			 * Singleton.primary_email_id = json_userinfo
			 * .getString("primary_email_id");
			 * System.out.println("Primary Email Id : " +
			 * Singleton.primary_email_id);
			 * 
			 * Singleton.login_code = json.getInt("code");
			 * System.out.println("Login Code : " + Singleton.login_code);
			 * 
			 * Intent i = new Intent(Jewelspark_Signin.this,
			 * MainActivity.class); startActivity(i);
			 * 
			 * } else {
			 * 
			 * showAlertDialog(Jewelspark_Signin.this,
			 * "Please try again later"); } } catch (JSONException e) { // TODO
			 * Auto-generated catch block e.printStackTrace(); }
			 */}

	}
}
