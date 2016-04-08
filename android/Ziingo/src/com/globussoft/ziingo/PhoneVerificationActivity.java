package com.globussoft.ziingo;

import org.w3c.dom.Text;

import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

public class PhoneVerificationActivity extends Activity {

	TextView txt_sms, rsnd_code, verify, incrt_code, edit_phnum;
	EditText code;
	ImageView bkbtn;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.phone_verification);
		initui();
	}

	public void initui() {
		txt_sms    = (TextView) findViewById(R.id.txt_sms);
		rsnd_code  = (TextView) findViewById(R.id.txt_resend);
		edit_phnum = (TextView) findViewById(R.id.txt_edit_num);
		verify     = (TextView) findViewById(R.id.txt_vr);
		incrt_code = (TextView) findViewById(R.id.txt_incorrect_code);
		code       = (EditText) findViewById(R.id.enter_code);
		bkbtn 	   = (ImageView) findViewById(R.id.cnfrm_ph_bk_btn);
		
		bkbtn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				onBackPressed();
			}
		});

		txt_sms.setText("We've sent you an SMS code to " + Singleton.delPh_num + " to verify and complete your account. ");		
		
		rsnd_code.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});
		
		edit_phnum.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

			}
		});
		
		verify.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				if (Singleton.ver_code == code.getText().toString()) 
				{
					incrt_code.setVisibility(View.INVISIBLE);
					
					// order confirmation
					
				} 
				else 
				{
					incrt_code.setVisibility(View.VISIBLE);
				}
				

			}
		});

	}
}
