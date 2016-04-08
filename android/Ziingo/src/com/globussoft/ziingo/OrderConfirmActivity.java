package com.globussoft.ziingo;

import com.globussoft.ziingo.fragment.OrderStatusFragment;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.TextView;

public class OrderConfirmActivity extends FragmentActivity {
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
	setContentView(R.layout.order_success);
	InitUi();
	}
	
	private void InitUi()
	{
	 TextView order_id = (TextView) findViewById(R.id.order_id);
	 ImageView goTo_os = (ImageView) findViewById(R.id.img_or_st);
	 
	 order_id.setText("ORDER ID: "+ Singleton.order_id);
	 
	 goTo_os.setOnClickListener(new OnClickListener() {
		
		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			
			Singleton.isNeedToShowOrderDetails = true;


			 finish();
			 

 			/*FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();*/           
            /*fragmentTransaction.replace(R.id.frame_container, fragmentOS);
            fragmentTransaction.commit();*/
			 
//            try
//            {
//            	MainActivity.mManager.beginTransaction().replace(R.id.frame_container, fragmentOS).commit();
//            	finish();
//            }
//            catch (IllegalStateException ignored) 
//            {
//            	System.out.println("-------- Ignored ---------");
//            }
           
		}
	});
		
	}

}
