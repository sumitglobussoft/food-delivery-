package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
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
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
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
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.FullUserDetailModel;
import com.globussoft.ziingo.twitterlib.Const;
import com.globussoft.ziingo.twitterlib.TwitterRequestCallBack;
import com.globussoft.ziingo.twitterlib.TwitterUserShowRequest;
import com.globussoft.ziingo.twitterlib.TwtSocioCallBack;
import com.globussoft.ziingo.twitterlib.TwtSocioLoginDialog;
import com.globussoft.ziingo.twitterlib.TwtSocioUserDatas;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.JSONParser;
import com.globussoft.ziingo.utills.Singleton;

public class SignUpActivity extends Activity {

	ConnectionDetector cd;
	EditText name, email, password, re_password;
	ProgressBar progress;

	// Shared Preferences
	public static SharedPreferences pref;

	// Editor for Shared preferences
	Editor editor;

	// Shared pref mode
	int PRIVATE_MODE = 0;

	int type;
	public static String fullname;

	CallbackManager callbackManager;
	AccessToken myAccessToken = null;
	String extendedAccessToken = null;

	JSONParser parser = new JSONParser();

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.signup);

		System.out.println("***** SignUp Activity *****");

		cd = new ConnectionDetector(getApplicationContext());
		FacebookSdk.sdkInitialize(SignUpActivity.this.getApplicationContext());
		callbackManager = CallbackManager.Factory.create();

		InitView();

	}

	protected void sharedPrefernces() {
		pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
		editor = pref.edit();
		editor.putString("Username", Singleton.name);
		editor.putString("email", Singleton.email);
		editor.putString("Password", Singleton.pass);
		editor.putString("social_id", Singleton.social_id);
		editor.putString("user_id", Singleton.user_id);
		editor.putBoolean("signUp_status", true);

		Singleton.signup_status = pref.getBoolean("signUp_status", true);
		editor.commit();

		System.out.println("******** Shared Preference ********");
		System.out.println("Username" + Singleton.name);
		System.out.println("email" + Singleton.email);
		System.out.println("Password" + Singleton.pass);
		System.out.println("social_id" + Singleton.social_id);
		System.out.println("user_id" + Singleton.user_id);
		System.out.println("signUp_status" + Singleton.signup_status);
		System.out.println("******** ******** ******** ********");
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
		callbackManager.onActivityResult(requestCode, resultCode, data);
	}

	private void InitView() {
		name = (EditText) findViewById(R.id.name);
		email = (EditText) findViewById(R.id.signup_email);
		password = (EditText) findViewById(R.id.password);
		re_password = (EditText) findViewById(R.id.re_password);
		// progress = (ProgressBar) findViewById(R.id.progress);

		ImageView signUp = (ImageView) findViewById(R.id.signup_btn);
		ImageView signUp_fb = (ImageView) findViewById(R.id.signup_btn_fb);
		ImageView signUp_twtr = (ImageView) findViewById(R.id.signup_btn_twitter);
		// ImageView close = (ImageView) findViewById(R.id.imageView4);
		// TextView already_acc = (TextView) findViewById(R.id.already_login);
		TextView login = (TextView) findViewById(R.id.already_login);
		TextView skip = (TextView) findViewById(R.id.skip);

		Singleton.name = name.getText().toString();
		Singleton.email = email.getText().toString();
		Singleton.pass = password.getText().toString();

		skip.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(SignUpActivity.this,
						Choose_spinner_country.class);
				startActivity(i);

			}
		});

		login.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(SignUpActivity.this, LoginActivity.class);
				startActivity(i);

			}
		});

		signUp.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {

				if (cd.isConnectingToInternet()) {
					if (name.getText().toString().length() > 1
							&& email.getText().toString().length() > 1
							&& password.getText().toString().length() > 1
							&& re_password.getText().toString().length() > 1) {

						if (password.getText().toString()
								.equals(re_password.getText().toString())) {

							Singleton.name = name.getText().toString();
							Singleton.email = email.getText().toString();
							Singleton.pass = password.getText().toString();

							System.out.println("Singleton.name == "
									+ Singleton.name);
							System.out.println("Singleton.email == "
									+ Singleton.email);
							System.out.println("Singleton.pass == "
									+ Singleton.pass);

							SignUpRequest(Singleton.name, Singleton.email,
									Singleton.pass, "1");

						}

						else {
							Toast.makeText(getApplicationContext(),
									"Please re-enter the correct password",
									Toast.LENGTH_LONG).show();
						}

					} else {
						Toast.makeText(getApplicationContext(),
								"Fill all the details", Toast.LENGTH_LONG)
								.show();
					}

				} else {
					Toast.makeText(getApplicationContext(),
							"Connect to Internet", Toast.LENGTH_LONG).show();
				}

			}

		});

		signUp_fb.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v)

			{
				// TODO Auto-generated method stub

				// LoginManager.getInstance().setLoginBehavior(LoginBehavior.SUPPRESS_SSO);

				LoginManager.getInstance()
						.logInWithReadPermissions(
								SignUpActivity.this,
								Arrays.asList("email", "user_friends",
										"public_profile"));

				LoginManager.getInstance().registerCallback(callbackManager,
						new FacebookCallback<LoginResult>()

						{
							@Override
							public void onSuccess(final LoginResult loginResult) {

								System.out.println("loginResult : "
										+ loginResult);

								myAccessToken = loginResult.getAccessToken();

								Singleton.social_id = loginResult
										.getAccessToken().getUserId();

								System.out.println("social_id >>>>>>>> "
										+ Singleton.social_id);

								GraphRequest request = GraphRequest.newMeRequest(
										loginResult.getAccessToken(),
										new GraphRequest.GraphJSONObjectCallback() {
											@Override
											public void onCompleted(
													JSONObject object,
													GraphResponse response)

											{ // TODO Auto-generated

												Singleton.name = object
														.optString("name");

												System.out.println("FB_name = "
														+ Singleton.name);

												Singleton.fb_profilePicURL = "https://graph.facebook.com/"
														+ Singleton.social_id
														+ "/picture?type=large";

												try {
													if (object.has("email")) {
														Singleton.email = object
																.getString("email");
														System.out
																.println("email (Facebook)"
																		+ Singleton.email);

														SignUpRequest_Fb(
																Singleton.email,
																Singleton.social_id,
																Singleton.name,
																"2");

													} else {
														alertEmail();
													}

												} catch (JSONException e) {
													e.printStackTrace();
												}

											}

											public void alertEmail() {
												// TODO Auto-generated method
												// stub

												AlertDialog.Builder alert = new AlertDialog.Builder(
														SignUpActivity.this);

												final EditText edittext = new EditText(
														SignUpActivity.this);
												edittext.setTextColor(Color.BLACK);
												alert.setMessage("Enter Your Email Id");

												// alert.setTitle("Email Id");

												alert.setView(edittext);

												alert.setPositiveButton(
														"OK",
														new DialogInterface.OnClickListener() {
															public void onClick(
																	DialogInterface dialog,
																	int whichButton)

															{
																// if(edittext.getText().toString().length()
																// != 0) {
																Singleton.email = edittext
																		.getText()
																		.toString();

																SignUpRequest_Fb(
																		Singleton.email,
																		Singleton.social_id
																				.toString(),
																		Singleton.name,
																		"2");
																// }

															}

														});

												alert.setNegativeButton(
														"Cancel",
														new DialogInterface.OnClickListener()

														{
															public void onClick(
																	DialogInterface dialog,
																	int whichButton) {

															}

														});

												alert.show();

											}
										});

								request.executeAsync();
							}

							@Override
							public void onCancel() {
								// TODO Auto-generated method stub
								AccessToken.setCurrentAccessToken(null);
							}

							@Override
							public void onError(FacebookException error) {
								// TODO Auto-generated method stub
								AccessToken.setCurrentAccessToken(null);
							}

						});

			}
		});

		signUp_twtr.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				signUpWithTWT();

			}
		});

	}

	public void SignUpRequest_Fb(final String email, final String social_id,
			final String name, final String type) {
		// TODO Auto-generated method stub

		// progress.setVisibility(View.VISIBLE);

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_signup,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("SignUp response" + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								JSONObject obj = json.getJSONObject("data");

								Singleton.user_id = obj.getString("user_id");

								System.out.println("message >>>>>>>>>" + msg);
								System.out.println("user_id >>>>>>>>" + Singleton.user_id);

								// sharedPrefernces();

								Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
								startActivity(intent);

								// finish();

							} 
							else if (json.getString("code").equals("198")) 
							{
								Toast.makeText(getApplicationContext(), "You have already registered. Please login.",
										Toast.LENGTH_LONG).show();
								Intent i = new Intent(SignUpActivity.this, LoginActivity.class);
								startActivity(i);
							}

							else {
								// if (json.getString("code").equals("201")) {

								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_SHORT).show();
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
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("email", email);
				params.put("name", name);
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

	private void SignUpRequest(final String name, final String email,
			final String pass, final String type) {
		// progress.setVisibility(View.VISIBLE);

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_signup,
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

								System.out.println("message >>>>>>>>>" + msg);
								System.out.println("user_id >>>>>>>>" + Singleton.user_id);

								// sharedPrefernces();
								
								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_SHORT).show();

								/*Intent intent = new Intent(getApplicationContext(), UserProfile.class);
								startActivity(intent);*/
								
								Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
								startActivity(intent);

								// finish();

							} 
							else if (json.getString("code").equals("198")) 
							{
								Toast.makeText(getApplicationContext(), "You have already registered. Please login.",
										Toast.LENGTH_SHORT).show();
								
								Intent i = new Intent(SignUpActivity.this, LoginActivity.class);
								startActivity(i);
							}

							else {

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_SHORT).show();
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
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("email", email);
				params.put("password", pass);
				params.put("name", name);
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

	public void signUpWithTWT() {

		TwtSocioLoginDialog twtLogin = new TwtSocioLoginDialog(
				SignUpActivity.this, new TwtSocioCallBack() {

					@Override
					public void onSuccess(TwtSocioUserDatas twtSocioUserDatas) {
						// CommonMethods.showMyToast(getActivity(), "Login Success");

						System.out.println("<<<<<<<<<<<<       ONSUCCESS 1     >>>>>>>>>>>>>");

						System.out.println("Login Success twtSocioUserDatas >>>>>>>>> +" + twtSocioUserDatas);

						Singleton.social_id = twtSocioUserDatas.getUserid();
						Singleton.name = twtSocioUserDatas.getUsername();

						System.out.println("***** TWITTER ******");
						System.out.println("Singleton.social_id == " + Singleton.social_id);
						System.out.println("Singleton.name == " + Singleton.name);

						TwitterUserShowRequest request = new TwitterUserShowRequest(
								twtSocioUserDatas,
								new TwitterRequestCallBack() {

									@Override
									public void onSuccess(JSONObject jsonObject) {
										// TODO Auto-generated method stub

										System.out.println("<<<<<<<<<<<<  ONSUCCESS 2   >>>>>>>>>>>>>");

										System.out.println(" TwitterUserShowRequest jsonObject +"+ jsonObject);

										parseJsonResultForAccountData(jsonObject);
										
									}

									@Override
									public void onSuccess(String jsonResult) {
										// TODO Auto-generated method stub

										System.out.println("<<<<<<<<<<<<       ONSUCCESS 3     >>>>>>>>>>>>>");

									//	alertEmailtwt();
									//  signUpRequest_Twt(Singleton.email, Singleton.name, Singleton.social_id, "3");

										System.out.println("TwitterUserShowRequest jsonObject +" + jsonResult);

									}

									@Override
									public void onFailure(Exception e) 
									{
										// TODO Auto-generated method stub
										System.out.println("SignUp Success e +" + e);

									}

								});

						request.executeThisRequest(twtSocioUserDatas.getUsername());

					}

					@Override
					public void onFailure(Exception exception) {
						// CommonMethods.showMyToast(getActivity(), "Login failure "+exception);
						System.out.println("SignUp failure");

					}
				});

		twtLogin.startLogin();

	}

	protected void alertEmailtwt() {
		// TODO Auto-generated method stub

		AlertDialog.Builder alert = new AlertDialog.Builder(SignUpActivity.this);

		final EditText edittext = new EditText(SignUpActivity.this);
		edittext.setTextColor(Color.BLACK);
		alert.setMessage("Enter Your Email Id");

		alert.setView(edittext);

		alert.setPositiveButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int whichButton)

			{
				// if (edittext.getText().toString().length() != 0) {
				Singleton.email = edittext.getText().toString();

				System.out.println("Singleton.email == " + Singleton.email);

				signUpRequest_Twt(Singleton.email, Singleton.name, Singleton.social_id.toString(),  "3");
				// }

			}

		});

		alert.setNegativeButton("Cancel", new DialogInterface.OnClickListener()

		{
			public void onClick(DialogInterface dialog, int whichButton) {

			}

		});

		alert.show();
	}

	protected void parseJsonResultForAccountData(JSONObject jsonResult) {

		myprint("parseJsonResult  ");

		try {

			myprint("jsonResult   = " + jsonResult);

			FullUserDetailModel fullUserDetailModel = new FullUserDetailModel();

			fullUserDetailModel.setId(jsonResult.getString(Const.id_str));
			fullUserDetailModel.setFullName(jsonResult.getString(Const.name));

			fullname = jsonResult.getString(Const.name);

			System.out.println("FULLNAME >>>>>>>>> " + fullname);

			fullUserDetailModel.setUserName(jsonResult.getString(Const.screen_name));

		} catch (JSONException e) {

			e.printStackTrace();

		}

		//new SignUpWithTwitter().execute();
		
		runOnUiThread(new Runnable() {
			public void run() {
								
				alertEmailtwt();

			//	signUpRequest_Twt(Singleton.email, Singleton.name, Singleton.social_id, "3");
			}
		});		
		
	}

	private void myprint(String string) {
		// TODO Auto-generated method stub

	}

	protected void signUpRequest_Twt(final String email, final String name,
			final String social_id, final String type) {
		// TODO Auto-generated method stub

		System.out.println("SignUp result");
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());

		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_signup,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("TWITTER signup response" + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								JSONObject obj = json.getJSONObject("data");

								Singleton.user_id = obj.getString("user_id");

								System.out.println("message >>>>>>>>>" + msg);
								System.out.println("user_id >>>>>>>>" + Singleton.user_id);

								// sharedPrefernces();

								Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
								startActivity(intent);

								// finish();
							} 
							else if (json.getString("code").equals("198")) 
							{
								Toast.makeText(getApplicationContext(),
										"You have already registered. Please login.",
										Toast.LENGTH_LONG).show();
								
								Intent i = new Intent(SignUpActivity.this, LoginActivity.class);
								startActivity(i);
							}

							else {

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}
						
					}
				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						
						System.out.println("Errrrorrrrrrr" + error);
					}
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("email", email);
				params.put("name", name);
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
	
}
