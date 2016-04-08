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
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
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
import com.facebook.login.LoginBehavior;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.globussoft.ziingo.adapter.New_BagAdapter;
import com.globussoft.ziingo.fragment.New_Bag_Fragment;
import com.globussoft.ziingo.handler.DatabaseHandler;
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
	TextView skip, forgot_pwd;
	ImageView login_btn , login_fb ,login_twt, close;
	RelativeLayout newUser;

	ConnectionDetector cd;

	CallbackManager callbackManager;
	AccessToken myAccessToken = null;
	String extendedAccessToken = null;

	// Shared Preferences
	public static SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;
	
	New_BagAdapter bagAdp;
	DatabaseHandler db;	
	
	AlertDialog alert, alert1;
	
	EditText rst_code;

	@Override
	protected void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);

		FacebookSdk.sdkInitialize(LoginActivity.this.getApplicationContext());

		TwtSocioInitialize.initialize(ConstantData.TWITTER_KEY,
				ConstantData.TWITTER_SECRET, ConstantData.oauth_callbackURL);
		
		cd = new ConnectionDetector(getApplicationContext());

		callbackManager = CallbackManager.Factory.create();
		
		db = new DatabaseHandler(getApplicationContext());
		bagAdp = new New_BagAdapter(getApplicationContext(), New_Bag_Fragment.bagModelList);

		loggIn();

	}

	protected void sharedPrefernces() {
		pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
		editor = pref.edit();
		editor.putString("Username", Singleton.user_name);
		editor.putString("email", Singleton.email);
		editor.putString("Password", Singleton.pass);
		editor.putString("social_id", Singleton.social_id);
		editor.putString("user_id", Singleton.user_id);
		editor.putBoolean("Login_status", true);

		Singleton.LoginStatus = pref.getBoolean("Login_status", true);
		editor.commit();
	}

	private void loggIn() {
		
		email = (EditText) findViewById(R.id.email);
		password = (EditText) findViewById(R.id.password);
		skip = (TextView) findViewById(R.id.txt_loginSkip);
		forgot_pwd = (TextView) findViewById(R.id.forgot_pswd);
		login_btn = (ImageView) findViewById(R.id.login_btn);
		login_fb = (ImageView) findViewById(R.id.login_fb);
		login_twt = (ImageView) findViewById(R.id.login_gplus);
		close = (ImageView) findViewById(R.id.imageView4);
		newUser = (RelativeLayout) findViewById(R.id.rel_newuser);

		Singleton.email = email.getText().toString();
		Singleton.pass = password.getText().toString();
		
		email.setText("anuradhak@globussoft.in");
		password.setText("test");
		
		forgot_pwd.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				alertEmail1();
				
			}
		});

		skip.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(LoginActivity.this, Choose_spinner_country.class);
				startActivity(i);

			}
		});

		newUser.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(LoginActivity.this, SignUpActivity.class);
				startActivity(i);

			}
		});

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

				if (cd.isConnectingToInternet()) {
					if (email.getText().toString().length() > 1
							&& password.getText().toString().length() > 1) {

						Singleton.email = email.getText().toString();
						Singleton.pass = password.getText().toString();

						logInRequest(Singleton.email, Singleton.pass, "1");

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

	protected void alertEmail1() {
		// TODO Auto-generated method stub

			AlertDialog.Builder alert = new AlertDialog.Builder(LoginActivity.this);

			final EditText edittext = new EditText(LoginActivity.this);
			edittext.setTextColor(Color.BLACK);
			alert.setMessage("Enter Your Email Id to reset password.");
			alert.setTitle("Reset Password");

			alert.setView(edittext);

			alert.setPositiveButton("OK", 
					new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) 
						{
							Singleton.email = edittext.getText().toString();
							
							System.out.println("Singleton.email >> "+ Singleton.email);
							
							forgot_pass("EnterEmailId", Singleton.email);						
						}
					});

			alert.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {

						}
					});

			alert.show();		
	}

	private void forgot_pass(final String method, final String email) {
		// TODO Auto-generated method stub

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_forgot_password,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("forgot_password response" + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) 
							{
								Toast.makeText(getApplicationContext(), 
										"Reset code has been sent to your email.Please check your email.",
										Toast.LENGTH_LONG).show();
								
								ShowDialog1();	
							}

							else 
							{
								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}

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
				params.put("EmailId", email);
				params.put("method", method);				

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
	
	protected void ShowDialog1() {
		// TODO Auto-generated method stub

		AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
		LayoutInflater inflater = this.getLayoutInflater();
		
		View convertView = (View) inflater.inflate(R.layout.resetpass_dialog, null);			
		
		TextView dialog_msg = (TextView) convertView.findViewById(R.id.txt_dialog_msg);
		TextView resend_cd = (TextView) convertView.findViewById(R.id.txt_rsndcd);
		TextView ok_btn = (TextView) convertView.findViewById(R.id.txt_rstokbtn);		
		TextView cancel_btn = (TextView) convertView.findViewById(R.id.txt_rstcancelbtn);
		ImageView close_btn = (ImageView) convertView.findViewById(R.id.close_btn);
		
		rst_code = (EditText) convertView.findViewById(R.id.rst_code);
		
		dialog_msg.setText("Please enter the verification code sent to "+Singleton.email);
		
		resend_cd.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				forgot_pass("EnterEmailId", Singleton.email);
				
			}
		});
		
		close_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				alert.dismiss();
				
			}
		});
		
		ok_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				System.out.println("Singleton.email >>> "+ Singleton.email);				
				System.out.println("rst_code.getText().toString() >>>> " + rst_code.getText().toString());
				
				enterResetCode("verifyResetCode", Singleton.email, rst_code.getText().toString());

			}
		});

		cancel_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				alert.dismiss();

			}
		});
		
		builder.setView(convertView);
		alert = builder.create();
		
		/*Window window = alert.getWindow();
		WindowManager.LayoutParams lp = window.getAttributes();		
		//lp.copyFrom(window.getAttributes());
		window.setGravity(Gravity.CENTER);

		// This makes the dialog take up the full width

		lp.width = WindowManager.LayoutParams.MATCH_PARENT;
		lp.height = WindowManager.LayoutParams.WRAP_CONTENT;
		lp.gravity = Gravity.CENTER;
		
		lp.x = 100; // The new position of the X coordinates
        lp.y = 100; // The new position of the Y coordinates
        lp.width = 300; // Width
        lp.height = 100; // Height
       // lp.alpha = 0.7f; // Transparency

		window.setAttributes(lp);*/
		alert.show();
	
	}

private void enterResetCode(final String method, final String email, final String reset ) {
// TODO Auto-generated method stub

RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
StringRequest sr = new StringRequest(Request.Method.POST,
		ConstantUrl.Url_main + ConstantUrl.Url_forgot_password,
		new Response.Listener<String>() {
			@Override
			public void onResponse(String response) {

				System.out.println("forgot_password response 2 " + response);
				try {
					JSONObject json = new JSONObject(response);

					String msg = json.getString("message");

					if (json.getString("code").equals("200")) {
						
						alert.dismiss();
						
						ShowDialog2();
						
					}

					else 
					{
						Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
					}

				} catch (Exception e) {
					e.printStackTrace();
				}

			}
		}, new Response.ErrorListener() {
			@Override
			public void onErrorResponse(VolleyError error) {
				
			}
		}) {
	@Override
	protected Map<String, String> getParams() {
		Map<String, String> params = new HashMap<String, String>();
		params.put("EmailId", email);
		params.put("method", method);
		params.put("resetcode",reset);

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
	
	protected void ShowDialog2() {
		// TODO Auto-generated method stub
		
		AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
		LayoutInflater inflater = this.getLayoutInflater();

		View convertView = (View) inflater.inflate(R.layout.newpassword, null);
		
		final EditText ed_new_pass = (EditText) convertView.findViewById(R.id.ed_new_pass);
		final EditText ed_new_repass = (EditText) convertView.findViewById(R.id.ed_new_repass);
		TextView newpassOk = (TextView) convertView.findViewById(R.id.txt_rstokbtn);
		ImageView close_btn = (ImageView) convertView.findViewById(R.id.close_btn1);
		
		close_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				alert1.dismiss();
				
			}
		});
		
		newpassOk.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				if(ed_new_pass.getText().toString().equals(ed_new_repass.getText().toString()))
				{
					System.out.println("rst_code.getText().toString() >> "+rst_code.getText().toString());
					System.out.println("ed_new_pass.getText().toString() >> "+ed_new_pass.getText().toString());
					System.out.println("ed_new_repass.getText().toString() >> "+ed_new_repass.getText().toString());
					
					newpassword("resetPassword", Singleton.email, rst_code.getText().toString(), 
							ed_new_pass.getText().toString(), ed_new_repass.getText().toString());
				}
				else
				{
					Toast.makeText(getApplicationContext(), "Please re-enter the correct password.", Toast.LENGTH_SHORT).show();
				}
				
				
			}
		});
		
		builder.setView(convertView);
		alert1 = builder.create();
		alert1.show();
	
	
	}

	private void newpassword(final String method, final String email, final String reset,
			final String pass, final String repass) 
	{
		// TODO Auto-generated method stub


		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_forgot_password,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						System.out.println("forgot_password response 3 " + response);
						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {
								
								alert1.dismiss();
								
								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
								
								alertemail2();
							}

							else 
							{
								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
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
				params.put("method", method);
				params.put("EmailId", email);				
				params.put("resetcode",reset);
				params.put("Password", pass);				
				params.put("rePassword",repass);

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

	protected void alertemail2()         {
		// TODO Auto-generated method stub

			AlertDialog.Builder alert = new AlertDialog.Builder(LoginActivity.this);
			
			alert.setMessage("Password successfully changed. please try to login with new password.");
			
			alert.setPositiveButton("OK", 
					new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {

							
						//alert.dismiss();	
								
						}
					});

			alert.show();		
	
		
	}

	private void logInRequest(final String email, final String password,
			final String type) {

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
								Singleton.email = obj.getString("email");
								Singleton.user_name = obj.getString("uname");
								Singleton.prof_status = obj.getString("status");

								System.out.println("message >>>>>>>>>" + msg);
								System.out.println("user_id : >>>>>>>>" + Singleton.user_id);

								sharedPrefernces();
								if (!Singleton.userAtCart) 
								{
									/*Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
									startActivity(intent);*/
									
									if(Singleton.prof_status.equalsIgnoreCase("New User")) 
									{
										Intent intent = new Intent(getApplicationContext(), UserProfile.class);
										startActivity(intent);										
									}
									else
									{
										if (!Singleton.userAtOrderHistory) 
										{
											Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
											startActivity(intent);
										}
										Singleton.userAtOrderHistory = false;
										
										finish();								
										
									}
								}
								
								if(Singleton.fromSign)
								{
									Intent intent = new Intent(getApplicationContext(), MainActivity.class);
									startActivity(intent);	
									finish();
								}
								
								Singleton.fromSign = false;
								Singleton.userAtCart = false;
								
								finish();						
								
								
							}

							else
							{
								Toast.makeText(getApplicationContext(), msg,Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}

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

										Singleton.name = object.optString("name");

										System.out.println("FB_name = " + Singleton.name);

										Singleton.fb_profilePicURL = "https://graph.facebook.com/"
												+ Singleton.social_id
												+ "/picture?type=large";

										try {

											if (Singleton.email == null)

											{
												if (object.has("email")) {

													Singleton.email = object .getString("email");
													System.out.println("email " + Singleton.email);

													SignUpActivity SA = new SignUpActivity();

													SA.SignUpRequest_Fb(Singleton.email,Singleton.social_id,
															Singleton.name, "2");

													// LoginRequestWithFb(Singleton.social_id,"2");
												} else {
													alertEmail();
												}
											}

											else {
												LoginRequestWithFb(Singleton.social_id, "2");
											}

										} catch (JSONException e) {

											e.printStackTrace();
										}

									}

									private void alertEmail() {
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
																Singleton.social_id.toString(),
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

						System.out.println("<<<<<<<<<<<<       ONSUCCESS 1     >>>>>>>>>>>>>");

						System.out.println("Login Success twtSocioUserDatas >>>>>>>>> +"+ twtSocioUserDatas);

						Singleton.social_id = twtSocioUserDatas.getUserid();					

						LoginRequestWithTwt(Singleton.social_id, "3");
						
						TwitterUserShowRequest request = new TwitterUserShowRequest(
								twtSocioUserDatas, new TwitterRequestCallBack() {

									@Override
									public void onSuccess(JSONObject jsonObject) {
										// TODO Auto-generated method stub

										/*
										 * System.out.println("<<<<<<<<<<<<       ONSUCCESS 2     >>>>>>>>>>>>>");
										 * 
										 * System.out.println(" TwitterUserShowRequest jsonObject +" + jsonObject);
										 * 
										 * //parseJsonResultForAccountData(jsonObject);										 * 
										 * 
										 * LoginRequestWithTwt(social_id.toString(),"3");
										 */
									}

									@Override
									public void onSuccess(String jsonResult) {
										// TODO Auto-generated method stub
										
										 System.out.println("<<<<<<<<<<<<       ONSUCCESS 2     >>>>>>>>>>>>>" );

										LoginRequestWithTwt(Singleton.social_id, "3");
										System.out .println("  TwitterUserShowRequest jsonObject +"
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

								Singleton.user_id = obj.getString("user_id");
								Singleton.email = obj.getString("email");
								Singleton.user_name = obj.getString("uname");

								System.out.println("message >>>>>>>>> " + msg);
								System.out.println("twt_id >>>>>>>>" + Singleton.social_id);
								System.out.println("user_id >>>>>>>>" + Singleton.user_id);

								sharedPrefernces();
								
								if (!Singleton.userAtCart) 
								{
									/*Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
									startActivity(intent);*/
									
									if(Singleton.prof_status.equalsIgnoreCase("New User")) 
									{
										Intent intent = new Intent(getApplicationContext(), UserProfile.class);
										startActivity(intent);										
									}
									else
									{
										if (!Singleton.userAtOrderHistory) 
										{
											Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
											startActivity(intent);
										}
										Singleton.userAtOrderHistory = false;
										
										finish();								
										
									}
								}
								Singleton.userAtCart = false;
								
								finish();								

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
								Singleton.email = obj.getString("email");
								Singleton.user_name = obj.getString("uname");
								
								System.out.println("message >>>>>>>>> " + msg);
								System.out.println("fb_id >>>>>>>> " + Singleton.social_id);
								System.out.println("Singleton.user_id >>>>>>>>" + Singleton.user_id);

								sharedPrefernces();
								
								if (!Singleton.userAtCart) 
								{
									/*Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
									startActivity(intent);*/
									
									if(Singleton.prof_status.equalsIgnoreCase("New User")) 
									{
										Intent intent = new Intent(getApplicationContext(), UserProfile.class);
										startActivity(intent);										
									}
									else
									{
										if (!Singleton.userAtOrderHistory) 
										{
											Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
											startActivity(intent);
										}
										Singleton.userAtOrderHistory = false;
										
										finish();								
										
									}
								}
								Singleton.userAtCart = false;
								
								finish();	
								
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
			 * * String url = ConstantUrl.Url_main + ConstantUrl.Url_login;
			 * //key and value pair
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

		}

	}
}
